<?php

namespace Club\TaskBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class TaskListener
{
    protected $container;
    protected $em;
    protected $event_dispatcher;
    protected $logger;

    public function __construct($container, $em, $event_dispatcher, $logger)
    {
        $this->container = $container;
        $this->em = $em;
        $this->event_dispatcher = $event_dispatcher;
        $this->logger = $logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        try {
            switch (true) {
            case $this->container->get('club_installer.installer')->installerOpen():
            case HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType():
                return;
            }

            $tasks = $this->em->getRepository('ClubTaskBundle:Task')->getTasksToExecute();

            foreach ($tasks as $task) {
                $this->startTask($task);

                $event = new \Club\TaskBundle\Event\FilterTaskEvent($task);
                $this->event_dispatcher->dispatch(constant($task->getEvent().'::'.$task->getMethod()), $event);

                $this->stopTask($task);
            }
        } catch (\Exception $e) {
            $this->logger->err('Task Error! '.$e->getMessage());
        }
    }

    protected function startTask($task)
    {
        $task->setLocked(1);
        $task->setLastRunAt(new \DateTime());

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    protected function stopTask($task)
    {
        $task->setLocked(0);

        $date = new \DateTime();
        $diff = new \DateInterval('P'.$task->getTaskInterval());
        $date->add($diff);
        $task->setNextRunAt($date);
        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }
}
