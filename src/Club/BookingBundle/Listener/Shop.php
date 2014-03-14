<?php

namespace Club\BookingBundle\Listener;

class Shop
{
    private $container;
    private $em;
    private $event_dispatcher;
    private $club_booking;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->event_dispatcher = $container->get('event_dispatcher');
        $this->club_booking = $container->get('club_booking.booking');
    }

    public function onOrderPaid(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        foreach ($event->getOrder()->getOrderProducts() as $product) {
            if ($product->getType() == 'guest_booking') {
                if (preg_match("/#(\d+)$/", $product->getProductName(), $o)) {
                    $booking = $this->em->find('ClubBookingBundle:Booking', $o[1]);

                    if ($booking) {
                        $status = $this->container->get('club_booking.booking')->getConfirmStatus($booking->getFirstDate());
                        $booking->setStatus($status);

                        $this->club_booking->setBooking($booking);
                        $this->club_booking->save();
                    }
                }
            }
        }
    }
}
