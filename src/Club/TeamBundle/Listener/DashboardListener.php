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

  public function onMemberView(\Club\UserBundle\Event\FilterActivityEvent $event)
  {
    if (!$this->container->getParameter('club_team.public_user_activity')) return;

    $user = $event->getUser();

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getLatest($user);

    foreach ($schedules as $s) {

        $activity = array(
            'date' => $s->getFirstDate(),
            'type' => 'bundles/clublayout/images/icons/16x16/book.png',
            'message' => $this->templating->render('ClubTeamBundle:Dashboard:team_message.html.twig', array(
                'schedule' => $s
            ))
        );

        $event->appendActivities($activity, $s->getFirstDate()->format('U'));
    }
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $start = new \DateTime();
    $end = clone $start;
    $end->add(new \DateInterval('P1M'));

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, $event->getUser());

    $output .= $this->templating->render('ClubTeamBundle:Dashboard:team_table.html.twig', array(
      'schedules' => $schedules
    ));

    $event->setOutput($output);
  }
}
