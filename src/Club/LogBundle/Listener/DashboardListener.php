<?php

namespace Club\LogBundle\Listener;

class DashboardListener
{
  private $em;
  private $security_context;
  private $templating;

  public function __construct($em, $security_context, $templating)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->templating = $templating;
  }

  public function onAdminDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $logs = $this->em->getRepository('ClubLogBundle:Log')->getRecent(10);
    $output .= $this->templating->render('ClubLogBundle:Dashboard:log_table.html.twig', array(
      'logs' => $logs
    ));

    $event->setOutput($output);
  }
}
