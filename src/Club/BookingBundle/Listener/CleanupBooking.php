<?php

namespace Club\BookingBundle\Listener;

class CleanupBooking
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function onBookingCleanup(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        if (!$this->container->getParameter('club_booking.cancel_without_checkin')) return;

        $after = new \DateTime();
        $i = new \DateInterval('PT'.$this->container->getParameter('club_booking.confirm_minutes_after').'M');
        $after->sub($i);

        $bookings = $this->em->createQueryBuilder()
            ->select('b')
            ->from('ClubBookingBundle:Booking', 'b')
            ->where('b.end_date < :after')
            ->andWhere('b.status = :status')
            ->setParameter('after', $after)
            ->setParameter('status', \Club\BookingBundle\Entity\Booking::CONFIRMED)
            ->getQuery()
            ->getResult();

        foreach ($bookings as $booking) {
            $this->container->get('club_booking.booking')->setBooking($booking);
            $this->container->get('club_booking.booking')->remove();
        }

        $this->em->flush();
    }
}
