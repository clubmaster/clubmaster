<?php

namespace Club\EventBundle\Listener;

class IcalListener
{
    private $container;
    private $em;
    private $security_context;
    private $templating;
    private $router;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->security_context = $container->get('security.context');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
    }

    public function onUserIcal(\Club\UserBundle\Event\FilterUserEvent $event)
    {
        $events = $this->em->getRepository('ClubEventBundle:Attend')->findBy(
            array('user' => $event->getUser()->getId())
        );

        $output = $this->templating->render('ClubEventBundle:Ical:ical.html.twig', array(
            'events' => $events
        ));

        $event->appendOutput($output);
    }
}
