<?php

namespace Club\LogBundle\Listener;

class AttendEventListener
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function onEventAttend(\Club\EventBundle\Event\FilterAttendEvent $event)
    {
        $e = $event->getAttend()->getEvent();
        $user = $event->getAttend()->getUser();

        $log = new \Club\LogBundle\Entity\Log();
        $log->setEvent('onEventAttend');
        $log->setSeverity('informational');
        $log->setUser($user);
        $log->setLogType('event');
        $log->setLog('User attend to event: '.$e->getEventName());

        $this->em->persist($log);
        $this->em->flush();
    }

    public function onEventUnattend(\Club\EventBundle\Event\FilterAttendEvent $event)
    {
        $e = $event->getAttend()->getEvent();
        $user = $event->getAttend()->getUser();

        $log = new \Club\LogBundle\Entity\Log();
        $log->setEvent('onEventUnattend');
        $log->setSeverity('informational');
        $log->setUser($user);
        $log->setLogType('event');
        $log->setLog('User unattend to event: '.$e->getEventName());

        $this->em->persist($log);
        $this->em->flush();
    }
}
