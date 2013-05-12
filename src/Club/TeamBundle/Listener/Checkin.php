<?php

namespace Club\TeamBundle\Listener;

class Checkin
{
  private $container;
  private $em;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.default_entity_manager');
  }

  public function onCheckinUser(\Club\CheckinBundle\Event\FilterCheckinEvent $event)
  {
    if (!$this->container->getParameter('club_team.penalty_enabled')) return;

    $checkin = $event->getCheckin();

    $before = new \DateTime();
    $i = new \DateInterval('PT'.$this->container->getParameter('club_team.minutes_before_schedule').'M');
    $before->add($i);

    $after = new \DateTime();
    $i = new \DateInterval('PT'.$this->container->getParameter('club_team.minutes_after_schedule').'M');
    $after->sub($i);

    $schedules = $this->em->createQueryBuilder()
      ->select('su')
      ->from('ClubTeamBundle:ScheduleUser', 'su')
      ->leftJoin('su.schedule', 's')
      ->leftJoin('s.users', 'u')
      ->where('u.user = :user')
      ->andWhere('s.first_date < :before')
      ->andWhere('s.first_date > :after')
      ->setParameter('user', $checkin->getUser()->getId())
      ->setParameter('before', $before)
      ->setParameter('after', $after)
      ->getQuery()
      ->getResult();

    foreach ($schedules as $schedule) {
      $schedule->setConfirmed(true);
      $this->em->persist($schedule);
    }

    $this->em->flush();
  }
}
