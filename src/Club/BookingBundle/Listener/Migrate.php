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
        $repeats = $this->em->getRepository('ClubBookingBundle:PlanRepeat')->findAll();
        if (count($repeats) > 0) {
            // if we already has migrate our booking plans
            return;
        }

        // FIXME, has to add the coming version
        $plans = $this->em->getRepository('ClubBookingBundle:Plan')->findAll();


        foreach ($plans as $plan) {
            $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
            $repeat->setPlan($plan);
            $repeat->setRepeats('weekly');
            $repeat->setRepeatOn($plan->getDay());
            $repeat->setEndsType('after');
            $repeat->setEndsOn($plan->getPeriodEnd());

            $start = clone $this->getPeriodStart();
            $start->setTime(
                $this->getFirstTime()->format('H'),
                $this->getFirstTime()->format('i'),
                $this->getFirstTime()->format('s')
            );

            $end = clone $this->getPeriodEnd();
            $end->setTime(
                $this->getEndTime()->format('H'),
                $this->getEndTime()->format('i'),
                $this->getEndTime()->format('s')
            );

            $plan->setStart($start);
            $plan->setEnd($end);

            $plan->addPlanRepeat($repeat);
        }

        $em->persist($plan);
    }
}
