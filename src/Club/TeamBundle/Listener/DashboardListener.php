<?php

namespace Club\TeamBundle\Listener;

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

  public function onMemberView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    if (!$this->container->getParameter('club_team.public_user_activity')) return;

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
