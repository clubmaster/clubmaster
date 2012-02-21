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

  public function onTeamAttend(\Club\TeamBundle\Event\FilterTeamEvent $event)
  {
    $user = $event->getUser();
    $subscription = $this->em->getRepository('ClubShopBundle:Subscription')->getSingleActiveSubscriptionForTeam($user);
    $team = $event->getTeam();

    if ($subscription->getType() == 'ticket') {
      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(1);
      $log->setSubscription($subscription);
      $note =
        'Attend '.$team->getTeam()->getTeamName().
        ' on '.$team->getFirstDate()->format('Y-m-d').
        ', from '.$team->getFirstDate()->format('H:i').
        ' to '.$team->getEndDate()->format('H:i');
      $log->setNote($note);

      $this->em->persist($log);
      $this->em->flush();
    }
  }

  public function onTeamUnattend(\Club\TeamBundle\Event\FilterTeamEvent $event)
  {
    $user = $event->getUser();
    $team = $event->getTeam();
    $subscription = $this->em->getRepository('ClubShopBundle:Subscription')->getSingleActiveSubscriptionForTeam($user);

    if ($subscription->getType() == 'ticket') {

      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(-1);
      $log->setSubscription($subscription);
      $note =
        'Cancelled '.$team->getTeam()->getTeamName().
        ' on '.$team->getFirstDate()->format('Y-m-d').
        ', from '.$team->getFirstDate()->format('H:i').
        ' to '.$team->getEndDate()->format('H:i');
      $log->setNote($note);

      $this->em->persist($log);
      $this->em->flush();
    }
  }
}
