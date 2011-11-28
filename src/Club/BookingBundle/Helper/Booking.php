<?php

namespace Club\BookingBundle\Helper;

use Doctrine\ORM\EntityManager;

class Booking
{
  protected $em;
  protected $container;
  protected $error;
  protected $is_valid = true;
  protected $user;
  protected $date;
  protected $interval;
  protected $partner;
  protected $guest = false;

  public function __construct(EntityManager $em, $container)
  {
    $this->em = $em;
    $this->container = $container;
  }

  public function bindGuest(\Club\BookingBundle\Entity\Interval $interval, \DateTime $date, \Club\UserBundle\Entity\User $user)
  {
    $this->interval = $interval;
    $this->date = $date;
    $this->user = $user;
    $this->guest = true;

    $this->validate();

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

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_day'))
      $this->setError('You cannot have more guest bookings this day');

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

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_future'))
      $this->setError('You cannot have more guest bookings');
  }

  public function bindUser(\Club\BookingBundle\Entity\Interval $interval, \DateTime $date, \Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\User $partner)
  {
    $this->interval = $interval;
    $this->date = $date;
    $this->user = $user;
    $this->partner = $partner;

    $this->validate();

    if ($user == $partner)
      $this->setError('You cannot book with yourself');

    $bookings = $this->em->createQueryBuilder()
      ->select('b')
      ->from('ClubBookingBundle:Booking', 'b')
      ->where('b.date >= CURRENT_DATE()')
      ->andWhere('b.user = :user')
      ->setParameter('user', $this->user->getId())
      ->setParameter('is_guest', false)
      ->getQuery()
      ->getResult();

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_same_partner_future'))
      $this->setError('You cannot have more guest bookings');
  }

  public function getError()
  {
    return $this->error;
  }

  public function isValid()
  {
    return $this->is_valid;
  }

  public function save()
  {
    $booking = new \Club\BookingBundle\Entity\Booking();
    $booking->setUser($this->user);
    $booking->setInterval($this->interval);
    $booking->setDate($this->date);
    $booking->setGuest($this->guest);

    if ($this->partner)
      $booking->addUser($this->partner);

    $this->em->persist($booking);
    $this->em->flush();

    return $booking;
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
}
