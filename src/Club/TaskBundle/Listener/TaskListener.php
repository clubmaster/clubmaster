<?php

namespace Club\TaskBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class TaskListener
{
  protected $em;
  protected $event_dispatcher;

  public function __construct($em, $event_dispatcher)
  {
    $this->em = $em;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
    $tasks = $this->em->getRepository('\Club\TaskBundle\Entity\Task')->getTasksToExecute();

    foreach ($tasks as $task) {
      $task = $this->startTask($task);

      $event = new \Club\TaskBundle\Event\FilterTaskEvent($task);
      $this->event_dispatcher->dispatch(\Club\TaskBundle\Event\Events::onGroupTask, $event);

      $task = $this->stopTask($task);
    }
  }

  protected function startTask($task)
  {
    $task->setLocked(1);
    $this->em->persist($task);
    $this->em->flush();

    return $task;
  }

  protected function stopTask($task)
  {
    $task->setLocked(0);

    $date = new \DateTime();
    $date->modify($task->getTaskInterval());
    $task->setNextRunAt($date);
    $this->em->persist($task);
    $this->em->flush();

    return $task;
  }
}
