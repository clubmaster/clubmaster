<?php

namespace Club\TeamBundle\Listener;

class TeamPenaltyListener
{
  private $em;
  private $minutes_before_schedule;
  private $penalty_enabled;
  private $order;

  public function __construct($em, $minutes_before_schedule, $penalty_enabled,$order)
  {
    $this->em = $em;
    $this->minutes_before_schedule = $minutes_before_schedule;
    $this->penalty_enabled = $penalty_enabled;
    $this->order = $order;
  }

  public function onTeamPenalty(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getNotProcessed();

    foreach ($schedules as $schedule) {
      foreach ($schedule->getUsers() as $user) {

        $last = clone $schedule->getFirstDate();
        $diff = new \DateInterval('PT'.$this->minutes_before_schedule.'M');
        $first = clone $schedule->getFirstDate()->sub($diff);

        $participant = $this->em->getRepository('ClubTeamBundle:Participant')->getUserInRange($user, $first, $last);
        if (!count($participant)) {
          if ($this->penalty_enabled) {
            $this->order->createSimpleOrder($user,$schedule->getLocation());
            $product = array(
              'price' => $schedule->getPenalty(),
              'quantity' => 1,
              'type' => 'product',
              'product_name' => 'Penalty for missed team'
            );
            $this->order->addSimpleProduct($product);
            $this->order->save();
          }
        }
      }

      $schedule->setProcessed(true);
      $this->em->persist($schedule);
    }

    $this->em->flush();
  }
}
