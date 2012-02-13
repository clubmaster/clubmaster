<?php

namespace Club\LogBundle\Listener;

class TaskListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onTaskError(\Club\LogBundle\Event\FilterLogEvent $event)
  {
    $log = new \Club\LogBundle\Entity\Log();
    $log->setEvent($event->getEvent());
    $log->setSeverity($event->getSeverity());
    $log->setLogType($event->getType());
    $log->setLog($event->getMessage());

    $this->em->persist($log);
    $this->em->flush();
  }
}
