<?php

namespace Club\TeamBundle\Helper;

use Doctrine\ORM\EntityManager;

class Team
{
  protected $em;
  protected $container;
  protected $security_context;
  protected $error;
  protected $is_valid = true;
  protected $user;
  protected $schedule;

  public function __construct(EntityManager $em, $container, $security_context)
  {
    $this->em = $em;
    $this->container = $container;
    $this->security_context = $security_context;
  }

  public function bindUnattend(\Club\TeamBundle\Entity\Schedule $schedule, \Club\UserBundle\Entity\User $user)
  {
    $this->schedule = $schedule;
    $this->user = $user;

    if ($this->security_context->isGranted('ROLE_TEAM_ADMIN'))
      return;

    if ($this->security_context->getToken()->getUser() != $user) {
      $this->setError('You do not have permissions to unattend this team');
      return;
    }

    $book_time = clone $this->schedule->getFirstDate();

    $now = new \DateTime();
    if ($book_time < $now) {
      $this->setError('You cannot unattend teams in the past');
      return;
    }

    $diff = ($now->getTimestamp()-$this->schedule->getCreatedAt()->getTimestamp());
    if ($diff < $this->container->getParameter('club_team.cancel_minute_created')*60)
      return;

    $delete_within = clone $book_time;
    $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_team.cancel_minute_before').'M'));
    if ($delete_within < new \DateTime())
      $this->setError('Cannot unattend team because time range is too small');
  }

  public function bindAttend(\Club\TeamBundle\Entity\Schedule $schedule, \Club\UserBundle\Entity\User $user)
  {
    $this->schedule = $schedule;
    $this->user = $user;

    $this->validate();

    if (!$this->isValid())
      return;

    if ($res[1] >= $this->container->getParameter('club_booking.num_book_guest_day')) {
      $this->setError('You cannot have more guest bookings this day');
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
    $this->schedule->getUsers()->removeElement($this->user);
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
      $this->setError('You cannot attend in the past');

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
