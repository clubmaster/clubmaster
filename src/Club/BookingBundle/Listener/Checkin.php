<?php

namespace Club\BookingBundle\Listener;

class Checkin
{
  private $container;
  private $em;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
  }

  public function onCheckin(\Club\CheckinBundle\Event\FilterCheckinEvent $event)
  {
    if ($this->container->getParameter('club_booking.auto_confirm')) return;

    $checkin = $event->getCheckin();

    $before = new \DateTime();
    $i = new \DateInterval('PT'.$this->container->getParameter('club_booking.confirn_minutes_before').'M');
    $before->add($i);

    $after = new \DateTime();
    $i = new \DateInterval('PT'.$this->container->getParameter('club_booking.confirm_minutes_after').'M');
    $after->sub($i);

    $bookings = $this->em->createQueryBuilder()
      ->select('b')
      ->from('ClubBookingBundle:Booking', 'b')
      ->leftJoin('b.users', 'u')
      ->where('b.user = :user OR u.id = :user')
      ->andWhere('b.first_date < :before')
      ->andWhere('b.first_date > :after')
      ->setParameter('user', $checkin->getUser()->getId())
      ->setParameter('before', $before)
      ->setParameter('after', $after)
      ->getQuery()
      ->getResult();

    foreach ($bookings as $booking) {
      $booking->setConfirmed(true);
      $this->em->persist($booking);
    }

    $this->em->flush();
  }
}
