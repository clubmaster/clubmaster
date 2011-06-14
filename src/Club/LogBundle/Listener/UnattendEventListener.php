<?php

namespace Club\LogBundle\Listener;

class UnattendEventListener
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onEventUnattend(\Club\EventBundle\Event\FilterEventEvent $event)
  {
    $e = $event->getEvent();
    $user = $this->security_context->getToken()->getUser();

    $log = new \Club\LogBundle\Entity\Log();
    $log->setEvent('onEventUnattend');
    $log->setUser($user);
    $log->setLogType('event');
    $log->setLog('User unattend to event: '.$e->getEventName());

    $this->em->persist($log);
    $this->em->flush();
  }
}
