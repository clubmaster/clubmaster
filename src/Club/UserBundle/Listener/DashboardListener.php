<?php

namespace Club\UserBundle\Listener;

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

    $users = $this->em->getRepository('ClubUserBundle:User')->findBy(
      array(),
      array('id' => 'DESC'),
      10
    );

    $output .= $this->templating->render('ClubUserBundle:Dashboard:user_table.html.twig', array(
      'users' => $users
    ));

    $event->setOutput($output);
  }
}
