<?php

namespace Club\BookingBundle\Helper;

class Booking
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
  protected $date;
  protected $interval;
  protected $partner;
  protected $booking;
  protected $guest = false;
  protected $is_valid = true;
  protected $price;
  protected $subscriptions;

  public function __construct($container)
  {
    $this->container = $container;
    $this->club_interval = $container->get('club_booking.interval');
    $this->security_context = $container->get('security.context');
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->session = $container->get('session');
    $this->translator = $container->get('translator');
    $this->event_dispatcher = $container->get('event_dispatcher');
    $this->price = 0;
  }

  public function bindDelete(\Club\BookingBundle\Entity\Booking $booking)
  {
    $this->booking = $booking;

    if ($this->security_context->isGranted('ROLE_BOOKING_ADMIN'))

      return;

    if (!$this->booking->isOwner($this->security_context->getToken()->getUser()))
      $this->setError($this->translator->trans('You do not have permissions to delete this booking'));

    if ($this->booking->getFirstDate() < new \DateTime()) {
      $this->setError($this->translator->trans('You cannot delete bookings in the past'));

      return;
    }

    $now = new \DateTime();
    $diff = ($now->getTimestamp()-$this->booking->getCreatedAt()->getTimestamp());
    if ($diff < $this->container->getParameter('club_booking.cancel_minute_created')*60)

      return;

    $delete_within = clone $booking->getFirstDate();
    $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_booking.cancel_minute_before').'M'));
    if ($delete_within < new \DateTime())
      $this->setError($this->translator->trans('Cannot delete booking because time range is too small'));
  }

  public function bindUser(\Club\BookingBundle\Entity\Interval $interval, \DateTime $date, \Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\User $partner)
  {
    $this->interval = $interval;
    $this->date = $date;
    $this->user = $user;
    $this->partner = $partner;

    $this->validate();
    if (!$this->isValid())

      return;

    if ($user == $partner) {
      $this->setError($this->translator->trans('You cannot book with yourself'));

      return;
    }

    if (!$this->validateSubscription($this->partner)) {
      $this->setError($this->translator->trans('Your partner must have an active membership'));

      return;
    }

    if (!$this->validateSubscriptionTime($this->partner)) {
      $this->setError($this->translator->trans('Your partner is not allowed to book this time.'));

      return;
    }

    if (!$this->validateBookingPartnerDay($this->date, $this->user, $this->partner)) {
      $this->setError($this->translator->trans('You cannot have more bookings with this partner this day'));

      return;
    }

    if (!$this->validateBookingPartnerFuture($this->user, $this->partner)) {
      $this->setError($this->translator->trans('You cannot have more bookings with this partner'));

      return;
    }

    if (!$this->validateBookingDay($this->date, $this->partner)) {
      $this->setError($this->translator->trans('Your partner cannot have more bookings this day'));

      return;
    }

    if (!$this->validateBookingFuture($this->partner)) {
      $this->setError($this->translator->trans('Your partner cannot have more bookings'));

      return;
    }

    $this->bind();
  }

  public function bindGuest(\Club\BookingBundle\Entity\Interval $interval, \DateTime $date, \Club\UserBundle\Entity\User $user)
  {
    $this->interval = $interval;
    $this->date = $date;
    $this->user = $user;
    $this->guest = true;

    $this->validate();

    if (!$this->isValid())

      return;

    if (!$this->container->getParameter('club_booking.enable_guest'))
      $this->setError($this->translator->trans('Guest booking is not enabled'));

    if (!$this->validateBookingGuestDay($this->date, $this->user)) {
      $this->setError($this->translator->trans('You cannot have more guest bookings this day'));

      return;
    }

    if (!$this->validateBookingGuestFuture($this->user)) {
      $this->setError($this->translator->trans('You cannot have more guest bookings'));

      return;
    }

    $this->setPrice($this->container->getParameter('club_booking.guest_price'));
    $this->bind();
  }

  public function getError()
  {
    return $this->error;
  }

  public function isValid()
  {
    return $this->is_valid;
  }

  public function bind()
  {
    $start = clone $this->date;
    $start->setTime(
      $this->interval->getStartTime()->format('H'),
      $this->interval->getStartTime()->format('i'),
      $this->interval->getStartTime()->format('s')
    );

    $stop = clone $this->date;
    $stop->setTime(
      $this->interval->getStopTime()->format('H'),
      $this->interval->getStopTime()->format('i'),
      $this->interval->getStopTime()->format('s')
    );

    $this->booking = new \Club\BookingBundle\Entity\Booking();
    $this->booking->setUser($this->user);
    $this->booking->setFirstDate($start);
    $this->booking->setField($this->interval->getField());
    $this->booking->setEndDate($stop);
    $this->booking->setGuest($this->guest);

    $confirm = $this->getConfirmStatus($start);
    $this->booking->setConfirmed($confirm);

    if ($this->partner)
      $this->booking->addUser($this->partner);
  }

  private function getConfirmStatus(\DateTime $start)
  {
    $confirm = ($this->container->getParameter('club_booking.auto_confirm')) ? true : false;
    if ($confirm) return $confirm;

    $now = new \DateTime();
    $before = clone $start;
    $i = new \DateInterval('PT'.$this->container->getParameter('club_booking.confirm_minutes_before').'M');
    $before->sub($i);

    return ($now > $before) ? true : false;
  }

  public function save()
  {
    $this->bind();

    $this->em->persist($this->booking);
    $this->em->flush();

    $event = new \Club\BookingBundle\Event\FilterBookingEvent($this->booking);
    $this->event_dispatcher->dispatch(\Club\BookingBundle\Event\Events::onBookingConfirm, $event);

    if ($this->getPrice() > 0) {
      $product = new \Club\ShopBundle\Entity\CartProduct();
      $product->setPrice($this->container->getParameter('club_booking.guest_price'));
      $product->setQuantity(1);
      $product->setType('guest_booking');
      $product->setProductName($this->translator->trans('Guest booking'));

      $this->container->get('order')->createSimpleOrder($this->container->get('security.context')->getToken()->getUser(), $this->booking->getField()->getLocation());
      $this->container->get('order')->addSimpleProduct($product);
      $this->container->get('order')->save();
    }

    return $this->booking;
  }

  public function remove()
  {
    $event = new \Club\BookingBundle\Event\FilterBookingEvent($this->booking);
    $this->event_dispatcher->dispatch(\Club\BookingBundle\Event\Events::onBookingCancel, $event);

    $this->em->remove($this->booking);
    $this->em->flush();
  }

  protected function setError($error)
  {
    $this->error = $error;
    $this->is_valid = false;
  }

  protected function validate()
  {
    if (!$this->validateIntervalDay($this->date)) {
      $this->setError($this->translator->trans('Interval does not exists that day'));

      return;
    }

    if (!$this->validatePast($this->date)) {
      $this->setError($this->translator->trans('You cannot book in the past'));

      return;
    }

    if (!$this->validateFuture($this->date)) {
      $this->setError($this->translator->trans('You cannot book that much in the future'));

      return;
    }

    if (!$this->validateAvailable($this->date)) {
      $this->setError($this->translator->trans('Interval is not available'));

      return;
    }

    if (!$this->validateSubscription($this->user)) {
      $this->setError($this->translator->trans('You do not have an active membership'));

      return;
    }

    if (!$this->validateSubscriptionTime($this->user)) {
      $this->setError($this->translator->trans('You are not allowed to book this time'));

      return;
    }

    if (!$this->validateBookingDay($this->date, $this->user)) {
      $this->setError($this->translator->trans('You cannot have more bookings this day'));

      return;
    }

    if (!$this->validateBookingFuture($this->user)) {
      $this->setError($this->translator->trans('You cannot have more bookings'));

      return;
    }
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }

  public function setBooking($booking)
  {
    $this->booking = $booking;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getBooking()
  {
    return $this->booking;
  }

  public function getInterval()
  {
    return $this->interval;
  }

  public function serialize()
  {
    $ret = array(
      'user' => $this->user->getId(),
      'date' => $this->date,
      'interval' => $this->interval->getId(),
      'guest' => $this->guest,
      'is_valid' => $this->is_valid,
      'price' => $this->price
    );

    if ($this->partner)
      $ret['partner'] = $this->partner->getId();

    $this->session->set('booking', serialize($ret));
  }

  public function unserialize()
  {
    $r = unserialize($this->session->get('booking'));

    $user = $this->em->find('ClubUserBundle:User', $r['user']);
    $interval = $this->em->find('ClubBookingBundle:Interval', $r['interval']);
    if (isset($r['partner'])) $partner = $this->em->find('ClubUserBundle:User', $r['partner']);

    $this->user = $user;
    $this->date = $r['date'];
    $this->interval = $interval;
    $this->guest = $r['guest'];
    $this->is_valid = $r['is_valid'];
    $this->price = $r['price'];

    if (isset($partner)) $this->partner = $partner;
  }

  protected function validateSubscription(\Club\UserBundle\Entity\User $user)
  {
    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'booking', null, $this->interval->getField()->getLocation());
    if (!$subs)

      return false;

    return true;
  }

  protected function validateSubscriptionTime(\Club\UserBundle\Entity\User $user)
  {
    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'booking', null, $this->interval->getField()->getLocation());
    if (!$subs)

      return false;

    foreach ($subs as $sub) {
      foreach ($sub->getSubscriptionAttributes() as $attr) {
        switch ($attr->getAttributeName()) {
        case 'start_time':
          $start = clone $this->interval->getStartTime();
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
          $end = clone $this->interval->getStopTime();
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

  protected function validateIntervalDay(\DateTime $date)
  {
    if ($date->format('N') != $this->interval->getDay())

      return false;

    return true;
  }

  protected function validateFuture(\DateTime $date)
  {
      $c = clone $date;
      $c->setTime(
          $this->interval->getStartTime()->format('H'),
          $this->interval->getStartTime()->format('i'),
          $this->interval->getStartTime()->format('s')
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

  protected function validatePast(\DateTime $date)
  {
    $c = clone $date;
    $c->setTime(
      $this->interval->getStartTime()->format('H'),
      $this->interval->getStartTime()->format('i'),
      $this->interval->getStartTime()->format('s')
    );

    if ($c < new \DateTime())

      return false;

    return true;
  }

  protected function validateAvailable(\DateTime $date)
  {
    $interval = $this->club_interval->getVirtualInterval($this->interval, $this->date);
    if (!$interval->getAvailable())

      return false;

    return true;
  }

  protected function validateBookingDay(\DateTime $date, \Club\UserBundle\Entity\User $user)
  {
    $start = clone $date;
    $end = clone $date;

    if ($start->format('Ymd') == date('Ymd')) {
      $start = new \DateTime();
    } else {
      $start->setTime(0,0,0);
    }
    $end->setTime(23,59,59);

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.first_date >= :start')
      ->andWhere('b.first_date <= :end')
      ->andWhere('b.user = :user')
      ->setParameter('user', $user->getId())
      ->setParameter('start', $start)
      ->setParameter('end', $end)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_day'))

      return false;

    return true;
  }

  protected function validateBookingFuture(\Club\UserBundle\Entity\User $user)
  {
    $date = new \DateTime();

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.first_date >= :date')
      ->andWhere('(b.user = :user OR u.id = :user)')
      ->setParameter('user', $user->getId())
      ->setParameter('date', $date)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_future'))

      return false;

    return true;
  }

  protected function validateBookingGuestDay(\DateTime $date, \Club\UserBundle\Entity\User $user)
  {
    $start = clone $date;
    $end = clone $date;

    if ($start->format('Ymd') == date('Ymd')) {
      $start = new \DateTime();
    } else {
      $start->setTime(0,0,0);
    }
    $end->setTime(23,59,59);

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.first_date >= :start')
      ->andWhere('b.first_date <= :end')
      ->andWhere('b.user = :user')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $user->getId())
      ->setParameter('is_guest', true)
      ->setParameter('start', $start)
      ->setParameter('end', $end)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_day'))

      return false;

    return true;
  }

  protected function validateBookingGuestFuture(\Club\UserBundle\Entity\User $user)
  {
    $date = new \DateTime();

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.first_date >= :date')
      ->andWhere('b.user = :user')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $user->getId())
      ->setParameter('is_guest', true)
      ->setParameter('date', $date)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_future'))

      return false;

    return true;
  }

  protected function validateBookingPartnerDay(\DateTime $date, \Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\User $partner)
  {
    $start = clone $date;
    $end = clone $date;

    if ($start->format('Ymd') == date('Ymd')) {
      $start = new \DateTime();
    } else {
      $start->setTime(0,0,0);
    }
    $end->setTime(23,59,59);

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.first_date >= :start')
      ->andWhere('b.first_date <= :end')
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

  protected function validateBookingPartnerFuture(\Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\User $partner)
  {
    $date = new \DateTime();

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.first_date >= :date')
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
