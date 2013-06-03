<?php

namespace Club\EventBundle\Helper;

use Club\EventBundle\Exception\EventException;

class Event
{
    protected $container;
    protected $em;
    protected $trans;
    protected $validator;
    protected $event_dispatcher;

    protected $attend;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->trans = $container->get('translator');
        $this->validator = $container->get('validator');
        $this->event_dispatcher = $container->get('event_dispatcher');
    }

    public function validateAttend(\Club\EventBundle\Entity\Event $event, \Club\UserBundle\Entity\User $user)
    {
        if (!$event->isOpen()) {
            throw new \Club\EventBundle\Exception\AttendNotAvailableException($this->trans->trans('Subscription to event is not open'));
        }

        $this->attend = new \Club\EventBundle\Entity\Attend();
        $this->attend->setUser($user);
        $this->attend->setEvent($event);

        $errors = $this->validator->validate($this->attend);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                throw new EventException($error->getMessage());
            }
        }

    }

    public function attend(\Club\EventBundle\Entity\Event $event, \Club\UserBundle\Entity\User $user)
    {
        $this->validateAttend($event, $user);

        $this->em->persist($this->attend);
        $this->em->flush();

        $e = new \Club\EventBundle\Event\FilterAttendEvent($this->attend);
        $this->event_dispatcher->dispatch(\Club\EventBundle\Event\Events::onEventAttend, $e);
    }
}
