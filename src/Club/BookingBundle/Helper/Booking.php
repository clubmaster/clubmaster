<?php

namespace Club\BookingBundle\Helper;

use Doctrine\ORM\EntityManager;

class Booking
{
  protected $em;
  protected $container;
  protected $security_context;
  protected $session;
  protected $error;
  protected $user;
  protected $date;
  protected $interval;
  protected $partner;
  protected $booking;
  protected $guest = false;
  protected $is_valid = true;
  protected $price;

  public function __construct(EntityManager $em, $container, $security_context, $session)
  {
    $this->em = $em;
    $this->container = $container;
    $this->security_context = $security_context;
    $this->session = $session;
  }

  public function bindDelete(\Club\BookingBundle\Entity\Booking $booking)
  {
    $this->booking = $booking;

    if ($this->security_context->isGranted('ROLE_BOOKING_ADMIN'))
      return;

    if ($this->booking->getUser() != $this->security_context->getToken()->getUser()) {
      $this->setError('You do not have permissions to delete this booking');
      return;
    }

    $book_time = clone $this->booking->getDate();
    $book_time->setTime(
      $this->booking->getInterval()->getStartTime()->format('H'),
      $this->booking->getInterval()->getStartTime()->format('i'),
      $this->booking->getInterval()->getStartTime()->format('s')
    );

    if ($book_time < new \DateTime()) {
      $this->setError('You cannot delete bookings in the past');
      return;
    }

    $now = new \DateTime();
    $diff = ($now->getTimestamp()-$this->booking->getCreatedAt()->getTimestamp());
    if ($diff < $this->container->getParameter('club_booking.cancel_minute_created')*60)
      return;

    $delete_within = clone $book_time;
    $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_booking.cancel_minute_before').'M'));
    if ($delete_within < new \DateTime())
      $this->setError('Cannot delete booking because time range is too small');
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
      $this->setError('Guest booking is not enabled');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.date = CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $this->user->getId())
      ->setParameter('is_guest', true)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_day')) {
      $this->setError('You cannot have more guest bookings this day');
      return;
    }

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.date >= CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $this->user->getId())
      ->setParameter('is_guest', true)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_future')) {
      $this->setError('You cannot have more guest bookings');
      return;
    }

    $this->bind();
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

    if ($user == $partner)
      $this->setError('You cannot book with yourself');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.date = CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->andWhere('u.id = :partner')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $this->user->getId())
      ->setParameter('partner', $this->partner->getId())
      ->setParameter('is_guest', false)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_same_partner_day')) {
      $this->setError('You cannot have more bookings with this partner this day');
      return;
    }

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.date >= CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->andWhere('u.id = :partner')
      ->andWhere('b.guest = :is_guest')
      ->setParameter('user', $this->user->getId())
      ->setParameter('partner', $this->partner->getId())
      ->setParameter('is_guest', false)
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_same_partner_future')) {
      $this->setError('You cannot have more bookings with this partner');
      return;
    }

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
    $this->booking = new \Club\BookingBundle\Entity\Booking();
    $this->booking->setUser($this->user);
    $this->booking->setInterval($this->interval);
    $this->booking->setDate($this->date);
    $this->booking->setGuest($this->guest);

    if ($this->partner)
      $this->booking->addUser($this->partner);
  }

  public function save()
  {
    $this->bind();

    $this->em->persist($this->booking);
    $this->em->flush();

    return $this->booking;
  }

  public function remove()
  {
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
    $c = clone $this->date;
    $c->setTime(
      $this->interval->getStartTime()->format('H'),
      $this->interval->getStartTime()->format('i'),
      $this->interval->getStartTime()->format('s')
    );

    if ($c < new \DateTime())
      $this->setError('You cannot book in the past');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.date = CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_day'))
      $this->setError('You cannot have more bookings this day');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(b)')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.date >= CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_future'))
      $this->setError('You cannot have more bookings');
  }

  public function getPrice()
  {
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
}
