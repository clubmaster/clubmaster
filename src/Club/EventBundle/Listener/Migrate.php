<?php

namespace Club\EventBundle\Listener;

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

        try {
            $events = $this->em->getRepository('ClubEventBundle:Event')->findAll();

            foreach ($events as $event) {
                $date = clone $event->getStartDate();
                $date->modify('-1 week');

                $event->setLastSubscribe($date);
                $this->em->persist($event);
            }
        } catch (\Exception $e) {
        }
    }
}
