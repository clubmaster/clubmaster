<?php

namespace Club\TeamBundle\Listener;

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
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->security_context = $container->get('security.context');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
    }

    public function onUserIcal(\Club\UserBundle\Event\FilterUserEvent $event)
    {
        $schedules = $this->em->getRepository('ClubTeamBundle:ScheduleUser')->findBy(
            array('user' => $event->getUser()->getId())
        );

        $output = $this->templating->render('ClubTeamBundle:Ical:ical.html.twig', array(
            'schedules' => $schedules
        ));

        $event->appendOutput($output);
    }
}
