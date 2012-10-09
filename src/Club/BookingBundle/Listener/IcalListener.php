<?php

namespace Club\BookingBundle\Listener;

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
        $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAll($event->getUser());

        $output = $this->templating->render('ClubBookingBundle:Ical:ical.html.twig', array(
            'bookings' => $bookings
        ));

        $event->appendOutput($output);
    }
}
