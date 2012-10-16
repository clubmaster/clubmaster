<?php

namespace Club\BookingBundle\Listener;

class Migrate
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function onVersionMigrate(\Club\InstallerBundle\Event\FilterVersionEvent $event)
    {
        if ($event->getVersion()->getVersion() != '20121016161300') {
            // fit to this version only
            return;
        }

        $repeats = $this->em->getRepository('ClubBookingBundle:PlanRepeat')->findAll();
        if (count($repeats) > 0) {
            // if we already has migrate our booking plans
            return;
        }

        $plans = $this->em->getRepository('ClubBookingBundle:Plan')->findAll();

        foreach ($plans as $plan) {
            $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
            $repeat->setPlan($plan);
            $repeat->setRepeats('weekly');
            $repeat->setRepeatOn($plan->getDay());
            $repeat->setEndsType('on');
            $repeat->setEndsOn($plan->getPeriodEnd());
            $repeat->setRepeatEvery(1);

            $start = clone $plan->getPeriodStart();
            $start->setTime(
                $plan->getFirstTime()->format('H'),
                $plan->getFirstTime()->format('i'),
                $plan->getFirstTime()->format('s')
            );

            $end = clone $plan->getPeriodStart();
            $end->setTime(
                $plan->getEndTime()->format('H'),
                $plan->getEndTime()->format('i'),
                $plan->getEndTime()->format('s')
            );

            $plan->setStart($start);
            $plan->setEnd($end);
            $plan->setRepeating(true);

            $plan->addPlanRepeat($repeat);

            $this->em->persist($plan);
        }

        $i = 0;
        $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->findAll();
        foreach ($bookings as $booking) {
            $i++;
            $booking->setStatus(2);
            $this->em->persist($booking);

            if ($i == 99) {
                $this->em->flush();
                $i = 0;
            }
        }
    }
}
