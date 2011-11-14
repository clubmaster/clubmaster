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
    $user = $this->security_context->getToken()->getUser();
    $subscription = $this->em->getRepository('ClubShopBundle:Subscription')->getSingleActiveSubscriptionForTeam($user);
    $subscription = $this->em->find('ClubShopBundle:Subscription', 4);
    $schedule = $event->getSchedule();

    if ($subscription->getType() == 'ticket') {
      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(1);
      $log->setSubscription($subscription);
      $note =
        'Attend '.$schedule->getTeam()->getTeamName().
        ' on '.$schedule->getFirstDate()->format('Y-m-d').
        ', from '.$schedule->getFirstDate()->format('H:i').
        ' to '.$schedule->getEndDate()->format('H:i');
      $log->setNote($note);

      $attr = new \Club\ShopBundle\Entity\SubscriptionTicketAttribute();
      $attr->setSubscriptionTicket($log);
      $attr->setAttribute('team');
      $attr->setValue($schedule->getId());

      $this->em->persist($attr);
      $this->em->persist($log);
      $this->em->flush();
    }
  }

  public function onTeamUnattend(\Club\TeamBundle\Event\FilterScheduleEvent $event)
  {
    $user = $this->security_context->getToken()->getUser();
    $schedule = $event->getSchedule();

    $attrs = $this->em->createQueryBuilder()
      ->select('sta')
      ->from('ClubShopBundle:SubscriptionTicketAttribute', 'sta')
      ->where('sta.attribute = :attr')
      ->andWhere('sta.value = :value')
      ->setMaxResults(1)
      ->orderBy('sta.created_at')
      ->setParameter('attr', 'team')
      ->setParameter('value', $schedule->getId())
      ->getQuery()
      ->getResult();

    foreach ($attrs as $attr) {
      $ticket = $attr->getSubscriptionTicket();

      $log = new \Club\ShopBundle\Entity\SubscriptionTicket();
      $log->setTickets(-1);
      $log->setSubscription($attr->getSubscriptionTicket()->getSubscription());
      $note =
        'Cancelled '.$schedule->getTeam()->getTeamName().
        ' on '.$schedule->getFirstDate()->format('Y-m-d').
        ', from '.$schedule->getFirstDate()->format('H:i').
        ' to '.$schedule->getEndDate()->format('H:i');
      $log->setNote($note);

      $this->em->persist($log);
      $this->em->flush();
    }
  }

}
