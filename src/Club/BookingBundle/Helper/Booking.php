<?php

namespace Club\BookingBundle\Helper;

use Doctrine\ORM\EntityManager;

class Booking
{
  protected $em;
  protected $container;
  protected $security_context;
  protected $error;
  protected $is_valid = true;
  protected $user;
  protected $date;
  protected $interval;
  protected $partner;
  protected $guest = false;
  protected $booking;

  public function __construct(EntityManager $em, $container, $security_context)
  {
    $this->em = $em;
    $this->container = $container;
    $this->security_context = $security_context;
  }

  public function bindDelete(\Club\BookingBundle\Entity\Booking $booking)
  {
    $this->booking = $booking;

    $c = clone $this->booking->getDate();
    $c->setTime(
      $this->booking->getInterval()->getStartTime()->format('H'),
      $this->booking->getInterval()->getStartTime()->format('i'),
      $this->booking->getInterval()->getStartTime()->format('s')
    );

    if ($c < new \DateTime())
      $this->setError('You cannot delete bookings in the past');

    if ((!$this->security_context->isGranted('ROLE_BOOKING_ADMIN')) && ($this->booking->getUser() != $this->security_context->getToken()->getUser()))
      $this->setError('You do not have permissions to delete this booking');
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
}
