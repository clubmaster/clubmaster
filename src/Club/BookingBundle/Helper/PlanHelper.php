<?php

namespace Club\BookingBundle\Helper;

use Club\BookingBundle\Entity\Plan;

class PlanHelper
{
    private $em;

    private $bookings = array();
    private $processed = false;
    private $available = true;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    public function isAvailable(Plan $plan)
    {
        return $this
            ->process($plan)
            ->available
            ;
    }

    public function getBookings()
    {
        return $this->bookings;
    }

    public function process(Plan $plan)
    {
        if ($this->processed) {
            return $this;
        }

        if (!$plan->getRepeating()) {
            foreach ($plan->getFields() as $field) {
                $bookings = $this->em->getRepository('ClubBookingBundle:Booking')
                    ->getAllBetween(
                        $plan->getStart(),
                        $plan->getEnd(),
                        $field
                    );

                if (count($bookings) > 0) {
                    $this->bookings[] = $bookings;

                    $this->available = false;
                }
            }
        } else {
            $start = new \DateTime();
            $end = new \DateTime();
            $end->modify('+1 month');

            $ics = $this->em->getRepository('ClubBookingBundle:Plan')->getIcsFromPlans(null, $plan);
            $calendar = \Sabre\VObject\Reader::read($ics);
            $calendar->expand($start, $end);

            foreach ($calendar->VEVENT as $event) {

                foreach ($plan->getFields() as $field) {

                    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllBetween(
                        $event->DTSTART->getDateTime(),
                        $event->DTEND->getDateTime(),
                        $field
                    );

                    if (count($bookings) > 0) {
                        foreach ($bookings as $booking) {
                            $this->bookings[] = $booking;

                            $this->available = false;
                        }
                    }
                }
            }
        }

        $this->processed = true;

        return $this;
    }
}
