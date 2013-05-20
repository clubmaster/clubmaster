<?php

namespace Club\TaskBundle\Listener;

class Migrate
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    public function onVersionMigrate(\Club\InstallerBundle\Event\FilterVersionEvent $event)
    {
        if ($event->getVersion()->getVersion() != '20121016161300') {
            // fit to this version only
            return;
        }

        $task = $this->em->getRepository('ClubTaskBundle:Task')->findOneBy(array(
            'method' => 'onLogTask'
        ));
	if ($task) $this->em->remove($task);

        $task = $this->em->getRepository('ClubTaskBundle:Task')->findOneBy(array(
            'method' => 'onLoginAttemptTask'
        ));
        if ($task) $this->em->remove($task);

        $task = $this->em->getRepository('ClubTaskBundle:Task')->findOneBy(array(
            'method' => 'onBanTask'
        ));
        if ($task) $this->em->remove($task);

        $tasks = array(
            array(
                'name' => 'Booking cleanup',
                'interval' => 'T1M',
                'method' => 'onBookingCleanup'
            ),
            array(
                'name' => 'Task cleanup',
                'interval' => 'T1M',
                'method' => 'onTaskCleanup'
            )
        );

        foreach ($tasks as $task) {
            $r = $this->em->getRepository('ClubTaskBundle:Task')->findOneBy(array(
                'method' => $task['method']
            ));

            if (!$r) {
                $t = new \Club\TaskBundle\Entity\Task();
                $t->setTaskName($task['name']);
                $t->setEnabled(1);
                $t->setLocked(0);
                $t->setNextRunAt(new \DateTime());
                $t->setTaskInterval($task['interval']);
                $t->setEvent('\Club\TaskBundle\Event\Events');
                $t->setMethod($task['method']);
                $this->em->persist($t);
            }
        }

    }
}
