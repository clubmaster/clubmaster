<?php

namespace Club\BookingBundle\Listener;

class Shop
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
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
                        $this->em->persist($booking);
                    }
                }
            }
        }

        $this->em->flush();
    }

    public function onOrderCancelled(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        foreach ($event->getOrder()->getOrderProducts() as $product) {
            if ($product->getType() == 'guest_booking') {
                if (preg_match("/#(\d+)$/", $product->getProductName(), $o)) {
                    $booking = $this->em->find('ClubBookingBundle:Booking', $o[1]);

                    if ($booking) {
                        $this->em->remove($booking);
                    }
                }
            }
        }

        $this->em->flush();
    }

}
