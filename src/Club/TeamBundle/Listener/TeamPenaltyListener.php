<?php

namespace Club\TeamBundle\Listener;

class TeamPenaltyListener
{
  private $em;
  private $minutes_before_schedule;
  private $penalty_enabled;
  private $order;
  private $penalty_product_name;

  public function __construct($em, $minutes_before_schedule, $penalty_enabled, $order, $penalty_product_name)
  {
    $this->em = $em;
    $this->minutes_before_schedule = $minutes_before_schedule;
    $this->penalty_enabled = $penalty_enabled;
    $this->order = $order;
    $this->penalty_product_name = $penalty_product_name;
  }

  public function onTeamPenalty(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getNotProcessed();

    foreach ($schedules as $schedule) {
      foreach ($schedule->getUsers() as $user) {

        $last = clone $schedule->getFirstDate();
        $diff = new \DateInterval('PT'.$this->minutes_before_schedule.'M');
        $first = clone $schedule->getFirstDate()->sub($diff);

        $participant = $this->em->getRepository('ClubTeamBundle:Participant')->getUserInRange($user->getUser(), $first, $last);
        if (!count($participant)) {
          if ($this->penalty_enabled) {
            $this->order->createSimpleOrder($user->getUser(),$schedule->getLocation());
            $product = array(
              'price' => $schedule->getPenalty(),
              'quantity' => 1,
              'type' => 'product',
              'product_name' => $this->penalty_product_name
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
