<?php

namespace Club\TeamBundle\Listener;

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

  public function onMemberView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $user = $event->getUser();
    $output = $event->getOutput();

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getLatest($user);
    $output .= $this->templating->render('ClubTeamBundle:Dashboard:member_table.html.twig', array(
      'schedules' => $schedules
    ));

    $event->setOutput($output);
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $start = new \DateTime();
    $end = clone $start;
    $end->add(new \DateInterval('P1M'));

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, $this->security_context->getToken()->getUser());

    $output .= $this->templating->render('ClubTeamBundle:Dashboard:team_table.html.twig', array(
      'schedules' => $schedules
    ));

    $event->setOutput($output);
  }
}
