<?php

namespace Club\LogBundle\Listener;

class LogListener
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onConnectionError(\Club\LogBundle\Event\FilterLogEvent $event)
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
