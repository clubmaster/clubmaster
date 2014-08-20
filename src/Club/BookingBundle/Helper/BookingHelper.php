<?php

namespace Club\BookingBundle\Helper;

use Club\BookingBundle\Exception\BookingException;
use Club\UserBundle\Entity\User;
use Club\UserBundle\Entity\Location;
use Club\BookingBundle\Entity\Booking;
use Club\BookingBundle\Entity\Interval;
use Club\BookingBundle\Entity\Field;
use Club\BookingBundle\Event\FilterBookingEvent;

class BookingHelper
{
    protected $em;
    protected $container;
    protected $security_context;
    protected $session;
    protected $club_interval;
    protected $translator;
    protected $event_dispatcher;
    protected $error;
    protected $user;
    protected $booking;
    protected $is_valid = true;
    protected $price;
    protected $subscriptions;

    public function __construct($container)
    {
        $this->container = $container;
        $this->club_interval = $container->get('club_booking.interval');
        $this->security_context = $container->get('security.context');
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->session = $container->get('session');
        $this->translator = $container->get('translator');
        $this->event_dispatcher = $container->get('event_dispatcher');
        $this->price = 0;
    }

    public function bindDelete(Booking $booking)
    {
        $this->booking = $booking;

        if ($this->booking->getFirstDate() < new \DateTime()) {
            $this->setError($this->translator->trans('You cannot delete bookings in the past'));

            return;
        }

        if ($this->security_context->isGranted('ROLE_BOOKING_ADMIN'))
            return;

        if (!$this->booking->isOwner($this->security_context->getToken()->getUser()))
            $this->setError($this->translator->trans('You do not have permissions to delete this booking'));

        $now = new \DateTime();
        $diff = ($now->getTimestamp()-$this->booking->getCreatedAt()->getTimestamp());
        if ($diff < $this->container->getParameter('club_booking.cancel_minute_created')*60)

            return;

        $delete_within = clone $booking->getFirstDate();
        $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_booking.cancel_minute_before').'M'));
        if ($delete_within < new \DateTime())
            $this->setError($this->translator->trans('Cannot delete booking %minutes% minutes before the time starts.', array(
                '%minutes%' => $this->container->getParameter('club_booking.cancel_minute_before')
            )));
    }

    public function bindAdditional(Booking $booking, User $user)
    {
        try {
            if ($user == $booking->getUser()) {
                throw new BookingException($this->translator->trans('You are already participating in the booking'));
            }

            foreach ($booking->getUsers() as $u) {
                if ($user == $u) {
                    throw new BookingException($this->translator->trans('You are already participating in the booking'));
                }
            }

            if (!$this->_validateSubscription($user, $booking->getField()->getLocation())) {
                throw new BookingException($this->translator->trans('You must have an active membership'));
            }

            if (!$this->validateBookingDay($booking->getFirstDate(), $user))
                throw new BookingException($this->translator->trans('You cannot have more bookings this day'));

            if (!$this->validateBookingFuture($user))
                throw new BookingException($this->translator->trans('You cannot have more bookings'));

        } catch (BookingException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function bindUser(Interval $interval, \DateTime $date, User $user, User $partner=null)
    {
        $start_date = $this->getStartDate($date, $interval);
        $stop_date = $this->getStopDate($date, $interval);

        $this->buildBooking($interval->getField(), $start_date, $stop_date, $user, $partner);

        try {
            $this->validate($this->booking, $interval);

            if ($user == $partner)
                throw new BookingException($this->translator->trans('You cannot book with yourself'));

            if (!$this->validateSubscription($partner, $interval))
                throw new BookingException($this->translator->trans('Your partner must have an active membership'));

            if (!$this->validateSubscriptionTime($partner, $interval))
                throw new BookingException($this->translator->trans('Your partner is not allowed to book this time.'));

            if (!$this->validateBookingPartnerDay($start_date, $user, $partner))
                throw new BookingException($this->translator->trans('You cannot have more bookings with this partner this day'));

            if (!$this->validateBookingPartnerFuture($user, $partner))
                throw new BookingException($this->translator->trans('You cannot have more bookings with this partner'));

            if (!$this->validateBookingDay($start_date, $partner))
                throw new BookingException($this->translator->trans('Your partner cannot have more bookings this day'));

            if (!$this->validateBookingFuture($partner))
                throw new BookingException($this->translator->trans('Your partner cannot have more bookings'));

        } catch (BookingException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function bindGuest(Interval $interval, \DateTime $date, User $user)
    {
        $start_date = $this->getStartDate($date, $interval);
        $stop_date = $this->getStopDate($date, $interval);

        $this->buildBooking($interval->getField(), $start_date, $stop_date, $user, null, true);

        try {
            $this->validate($this->booking, $interval);

            if (!$this->container->getParameter('club_booking.enable_guest'))
                throw new BookingException($this->translator->trans('Guest booking is not enabled'));

            if (!$this->validateBookingGuestDay($start_date, $user))
                throw new BookingException($this->translator->trans('You cannot have more guest bookings this day'));

            if (!$this->validateBookingGuestFuture($user))
                throw new BookingException($this->translator->trans('You cannot have more guest bookings'));

            $this->setPrice($this->container->getParameter('club_booking.guest_price'));

        } catch (BookingException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function getError()
    {
        return $this->error;
    }

    public function isValid()
    {
        return $this->is_valid;
    }

    public function getStopDate(\DateTime $date, Interval $interval)
    {
        $d = clone $date;
        $d->setTime(
            $interval->getStopTime()->format('H'),
            $interval->getStopTime()->format('i'),
            $interval->getStopTime()->format('s')
        );

        return $d;
    }

    public function getStartDate(\DateTime $date, Interval $interval)
    {
        $d = clone $date;
        $d->setTime(
            $interval->getStartTime()->format('H'),
            $interval->getStartTime()->format('i'),
            $interval->getStartTime()->format('s')
        );

        return $d;
    }

    private function buildBooking(Field $field, \DateTime $start_date, \DateTime $stop_date, User $user, User $partner=null, $guest=false)
    {
        $this->booking = new Booking();
        $this->booking->setUser($user);
        $this->booking->setFirstDate($start_date);
        $this->booking->setEndDate($stop_date);
        $this->booking->setField($field);
        $this->booking->setGuest($guest);
        $this->booking->setStatus($this->getConfirmStatus($start_date));

        if ($partner)
            $this->booking->addUser($partner);
    }

    public function getConfirmStatus(\DateTime $start)
    {
        $now = new \DateTime();
        $before = clone $start;
        $i = new \DateInterval('PT'.$this->container->getParameter('club_booking.confirm_minutes_before').'M');
        $before->sub($i);

        return ($now > $before)
            ? \Club\BookingBundle\Entity\Booking::CHECKIN
            : \Club\BookingBundle\Entity\Booking::CONFIRMED;
    }

    public function save()
    {
        $this->em->persist($this->booking);
        $this->em->flush();

        if ($this->booking->getStatus() >= Booking::CONFIRMED) {
            $event = new FilterBookingEvent($this->booking);
            $this->event_dispatcher->dispatch(\Club\BookingBundle\Event\Events::onBookingConfirm, $event);
        }

        $this->em->flush();

        return $this->booking;
    }

    public function addToCart()
    {
        $product = new \Club\ShopBundle\Entity\CartProduct();
        $product->setPrice($this->container->getParameter('club_booking.guest_price'));
        $product->setQuantity(1);
        $product->setType('guest_booking');
        $product->setProductName($this->translator->trans('Guest booking').', #'.$this->booking->getId());

        $cart = $this->container->get('cart');
        $cart
            ->getCurrent()
            ->addToCart($product);
    }

    public function cancel(\Club\BookingBundle\Entity\Booking $booking)
    {
        $booking->setStatus(\Club\BookingBundle\Entity\Booking::CANCELLED);
        $this->em->persist($booking);

        $event = new FilterBookingEvent($booking);
        $this->event_dispatcher->dispatch(\Club\BookingBundle\Event\Events::onBookingCancel, $event);
    }

    public function remove()
    {
        $event = new FilterBookingEvent($this->booking);
        $this->event_dispatcher->dispatch(\Club\BookingBundle\Event\Events::onBookingCancel, $event);

        $this->em->remove($this->booking);
    }

    protected function setError($error)
    {
        $this->error = $error;
        $this->is_valid = false;

        $partners = '';
        foreach ($this->booking->getUsers() as $partner) {
            $partners .= $partner->getId().', ';
        }

        $log = new \Club\LogBundle\Entity\Log();
        $log->setEvent('onBookingError');
        $log->setSeverity('informational');
        $log->setLogType('booking');
        $log->setLog(sprintf('Booking error: %s, with partners: %s', $error, $partners));

        $log->setUser($this->security_context->getToken()->getUser());

        $this->em->persist($log);
        $this->em->flush();
    }

    protected function validate(Booking $booking, Interval $interval)
    {
        try {
            if (!$this->validateIntervalDay($booking->getFirstDate(), $interval))
                throw new BookingException($this->translator->trans('Interval does not exists that day'));

            if (!$this->validatePast($booking->getFirstDate(), $interval))
                throw new BookingException($this->translator->trans('You cannot book in the past'));

            if (!$this->validateFuture($booking->getFirstDate(), $interval))
                throw new BookingException($this->translator->trans('You cannot book that much in the future'));

            if (!$this->validateAvailable($booking->getFirstDate(), $interval))
                throw new BookingException($this->translator->trans('Interval is not available'));

            if (!$this->validateSubscription($booking->getUser(), $interval))
                throw new BookingException($this->translator->trans('You do not have an active membership'));

            if (!$this->validateSubscriptionTime($booking->getUser(), $interval))
                throw new BookingException($this->translator->trans('You are not allowed to book this time'));

            if (!$this->validateBookingDay($booking->getFirstDate(), $booking->getUser()))
                throw new BookingException($this->translator->trans('You cannot have more bookings this day'));

            if (!$this->validateBookingFuture($booking->getUser()))
                throw new BookingException($this->translator->trans('You cannot have more bookings'));

        } catch (BookingException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setBooking($booking)
    {
        $this->booking = $booking;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getBooking()
    {
        return $this->booking;
    }

    public function setStatus($status)
    {
        $this->booking->setStatus($status);
    }

    public function serialize()
    {
        $this->session->set('booking', serialize($this->booking));
    }

    public function unserialize()
    {
        $b = unserialize($this->session->get('booking'));

        $partner = null;
        foreach ($b->getUsers() as $u) {
            $partner = $this->em->getReference('ClubUserBundle:User', $u->getId());;
        }

        $field = $this->em->getReference('ClubBookingBundle:Field', $b->getField()->getId());
        $user = $this->em->getReference('ClubUserBundle:User', $b->getUser()->getId());
        $this->buildBooking($field, $b->getFirstDate(), $b->getEndDate(), $user, $partner, $b->getGuest());
    }

    protected function validateSubscription(User $user, Interval $interval)
    {
        return $this->_validateSubscription($user, $interval->getField()->getLocation());
    }

    protected function _validateSubscription(User $user, Location $location)
    {
        $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'booking', null, $location);
        if (!$subs)

            return false;

        return true;
    }

    protected function validateSubscriptionTime(User $user, Interval $interval)
    {
        $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'booking', null, $interval->getField()->getLocation());
        if (!$subs) {
            return false;
        }

        foreach ($subs as $sub) {
            foreach ($sub->getSubscriptionAttributes() as $attr) {
                switch ($attr->getAttributeName()) {
                case 'start_time':
                    $start = clone $interval->getStartTime();
                    $start->setDate(
                        date('Y'),
                        date('m'),
                        date('d')
                    );
                    $t = new \DateTime(date('Y-m-d ').$attr->getValue());

                    if ($start < $t)

                        return false;

                    break;
                case 'stop_time':
                    $end = clone $interval->getStopTime();
                    $end->setDate(
                        date('Y'),
                        date('m'),
                        date('d')
                    );
                    $t = new \DateTime(date('Y-m-d ').$attr->getValue());

                    if ($end > $t)

                        return false;

                    break;
                }
            }
        }

        return true;
    }

    protected function validateIntervalDay(\DateTime $date, Interval $interval)
    {
        if ($date->format('N') != $interval->getDay())

            return false;

        return true;
    }

    protected function validateFuture(\DateTime $date, Interval $interval)
    {
        $c = clone $date;
        $c->setTime(
            $interval->getStartTime()->format('H'),
            $interval->getStartTime()->format('i'),
            $interval->getStartTime()->format('s')
        );

        $check_time = new \DateTime();
        $check_time->add(new \DateInterval('P'.$this->container->getParameter('club_booking.days_book_future').'D'));

        if ($this->container->getParameter('club_booking.days_book_future_entire_day')) {
            $check_time->setTime(
                23,
                59,
                59
            );
        }

        if ($c > $check_time)
            return false;

        return true;
    }

    protected function validatePast(\DateTime $date, Interval $interval)
    {
        $c = clone $date;
        $c->setTime(
            $interval->getStartTime()->format('H'),
            $interval->getStartTime()->format('i'),
            $interval->getStartTime()->format('s')
        );

        if ($c < new \DateTime())

            return false;

        return true;
    }

    protected function validateAvailable(\DateTime $date, Interval $interval)
    {
        $interval = $this->club_interval->getVirtualInterval($interval, $date);
        if (!$interval->getAvailable())

            return false;

        return true;
    }

    protected function validateBookingDay(\DateTime $date, User $user)
    {
        $start = clone $date;
        $end = clone $date;

        $start->setTime(0,0,0);
        $end->setTime(23,59,59);

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->where('b.end_date >= :start')
            ->andWhere('b.end_date <= :end')
            ->andWhere('b.user = :user')
            ->andWhere('b.status >= :status')
            ->setParameter('user', $user->getId())
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('status', \Club\BookingBundle\Entity\Booking::CONFIRMED)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_day'))

            return false;

        return true;
    }

    protected function validateBookingFuture(User $user)
    {
        $date = new \DateTime();

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->leftJoin('b.users', 'u')
            ->where('b.end_date >= :date')
            ->andWhere('(b.user = :user OR u.id = :user)')
            ->andWhere('b.status >= :status')
            ->setParameter('user', $user->getId())
            ->setParameter('date', $date)
            ->setParameter('status', \Club\BookingBundle\Entity\Booking::CONFIRMED)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_future'))

            return false;

        return true;
    }

    protected function validateBookingGuestDay(\DateTime $date, User $user)
    {
        $start = clone $date;
        $end = clone $date;

        $start->setTime(0,0,0);
        $end->setTime(23,59,59);

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->where('b.end_date >= :start')
            ->andWhere('b.end_date <= :end')
            ->andWhere('b.user = :user')
            ->andWhere('b.guest = :is_guest')
            ->andWhere('b.status >= :status')
            ->setParameter('user', $user->getId())
            ->setParameter('is_guest', true)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('status', \Club\BookingBundle\Entity\Booking::CONFIRMED)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_day'))

            return false;

        return true;
    }

    protected function validateBookingGuestFuture(User $user)
    {
        $date = new \DateTime();

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->where('b.end_date >= :date')
            ->andWhere('b.user = :user')
            ->andWhere('b.guest = :is_guest')
            ->andWhere('b.status >= :status')
            ->setParameter('user', $user->getId())
            ->setParameter('is_guest', true)
            ->setParameter('date', $date)
            ->setParameter('status', \Club\BookingBundle\Entity\Booking::CONFIRMED)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_future'))

            return false;

        return true;
    }

    protected function validateBookingPartnerDay(\DateTime $date, User $user, User $partner)
    {
        $start = clone $date;
        $end = clone $date;

        $start->setTime(0,0,0);
        $end->setTime(23,59,59);

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->leftJoin('b.users', 'u')
            ->where('b.end_date >= :start')
            ->andWhere('b.end_date <= :end')
            ->andWhere('b.user = :user')
            ->andWhere('u.id = :partner')
            ->andWhere('b.guest = :is_guest')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('user', $user->getId())
            ->setParameter('partner', $partner->getId())
            ->setParameter('is_guest', false)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_same_partner_day'))
            return false;

        return true;
    }

    protected function validateBookingPartnerFuture(User $user, User $partner)
    {
        $date = new \DateTime();

        $res = $this->em->createQueryBuilder()
            ->select('COUNT(b)')
            ->from('ClubBookingBundle:Booking', 'b')
            ->leftJoin('b.users', 'u')
            ->where('b.end_date >= :date')
            ->andWhere('b.user = :user')
            ->andWhere('u.id = :partner')
            ->andWhere('b.guest = :is_guest')
            ->setParameter('user', $user->getId())
            ->setParameter('partner', $partner->getId())
            ->setParameter('is_guest', false)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleResult();

        if ($res[1] >= $this->container->getParameter('club_booking.num_book_same_partner_future'))

            return false;

        return true;
    }
}
