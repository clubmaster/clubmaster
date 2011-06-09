<?php

namespace Club\TaskBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class TaskListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
    $tasks = $this->em->getRepository('\Club\TaskBundle\Entity\Task')->getTasksToExecute();

    foreach ($tasks as $task) {
      $task = $this->startTask($task);
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
