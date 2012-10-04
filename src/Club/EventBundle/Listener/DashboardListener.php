<?php

namespace Club\EventBundle\Listener;

class DashboardListener
{
  private $container;
  private $em;
  private $security_context;
  private $templating;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->templating = $container->get('templating');
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $start = new \DateTime();

    $events = $this->em->getRepository('ClubEventBundle:Event')->getComing();

    if (!count($events)) return;

    $output .= $this->templating->render('ClubEventBundle:Dashboard:event_table.html.twig', array(
      'events' => $events
    ));

    $event->setOutput($output);
  }
}
