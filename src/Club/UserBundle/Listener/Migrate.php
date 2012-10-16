<?php

namespace Club\UserBundle\Listener;

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

        $users = $this->em->getRepository('ClubUserBundle:User')->findAll();

        foreach ($users as $user) {
            $date = null;
            foreach ($user->getSubscriptions() as $s) {
                if ($date == null || $date < $s->getCreatedAt()) {
                    $date = clone $s->getCreatedAt();
                }
            }

            $user->setLastLoginTime($date);

            $this->em->persist($user);
        }
    }
}
