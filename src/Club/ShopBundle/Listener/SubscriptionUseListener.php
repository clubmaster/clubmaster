<?php

namespace Club\ShopBundle\Listener;

class SubscriptionUseListener
{
  protected $em;
  protected $security_context;

  public function __construct($em, $security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onTeamAttend(\Club\TeamBundle\Event\FilterScheduleEvent $event)
  {
    $user = $event->getUser();
    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'team');
    $subscription = reset($subs);

    $schedule = $event->getSchedule();

    if ($subscription->getType() == 'ticket') {
      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(1);
      $log->setSubscription($subscription);
      $note =
        'Attend '.$schedule->getTeamCategory()->getTeamName().
        ' on '.$schedule->getFirstDate()->format('Y-m-d').
        ', from '.$schedule->getFirstDate()->format('H:i').
        ' to '.$schedule->getEndDate()->format('H:i');
      $log->setNote($note);

      $this->em->persist($log);
      $this->em->flush();
    }
  }

  public function onTeamUnattend(\Club\TeamBundle\Event\FilterScheduleEvent $event)
  {
    $user = $event->getUser();
    $schedule = $event->getSchedule();
    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user, null, 'team');
    $subscription = reset($subs);

    if ($subscription->getType() == 'ticket') {

      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(-1);
      $log->setSubscription($subscription);
      $note =
        'Cancelled '.$schedule->getTeamCategory()->getTeamName().
        ' on '.$schedule->getFirstDate()->format('Y-m-d').
        ', from '.$schedule->getFirstDate()->format('H:i').
        ' to '.$schedule->getEndDate()->format('H:i');
      $log->setNote($note);

      $this->em->persist($log);
      $this->em->flush();
    }
  }
}
