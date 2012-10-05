<?php

namespace Club\EventBundle\Listener;

class DashboardListener
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

    public function onDashboardComing(\Club\UserBundle\Event\FilterActivityEvent $event)
    {
        $start = new \DateTime();
        $events = $this->em->getRepository('ClubEventBundle:Event')->getComing();

        if (!count($events)) return;

        foreach ($events as $e) {
            $activity = array(
                'date' => $e->getStartDate(),
                'type' => 'bundles/clublayout/images/icons/16x16/calendar.png',
                'link' => $this->router->generate('event_event_show', array( 'id' => $e->getId() )),
                'message' => $this->templating->render('ClubEventBundle:Dashboard:event_message.html.twig', array(
                    'event' => $e
                ))
            );
            $event->appendActivities($activity, $e->getStartDate()->format('U'));
        }
    }
}
