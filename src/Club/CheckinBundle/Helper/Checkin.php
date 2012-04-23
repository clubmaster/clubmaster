<?php

namespace Club\CheckinBundle\Helper;

class Checkin
{
  protected $em;
  protected $security_contenxt;
  protected $event_dispatcher;

  public function __construct($em, $security_context, $event_dispatcher)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function checkin()
  {
    $checkin = new \Club\CheckinBundle\Entity\Checkin();
    $checkin->setUser($this->security_context->getToken()->getUser());

    $this->em->persist($checkin);
    $this->em->flush();

    $event = new \Club\CheckinBundle\Event\FilterCheckinEvent($checkin);
    $this->event_dispatcher->dispatch(\Club\CheckinBundle\Event\Events::onCheckin, $event);

  }
}
