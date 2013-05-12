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
    $this->em = $container->get('doctrine.orm.default_entity_manager');
    $this->security_context = $container->get('security.context');
    $this->templating = $container->get('templating');
  }

  public function onMemberView(\Club\UserBundle\Event\FilterActivityEvent $event)
  {
    if (!$this->container->getParameter('club_team.public_user_activity')) return;

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getLatest($event->getUser());
    $this->process($event, $schedules);
  }

  public function onDashboardComing(\Club\UserBundle\Event\FilterActivityEvent $event)
  {
    $start = new \DateTime();
    $end = clone $start;
    $end->add(new \DateInterval('P1M'));

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, $event->getUser());

    $this->process($event, $schedules);
  }

  private function process($event, $schedules)
  {
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
}
