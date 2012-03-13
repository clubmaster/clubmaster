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
    if (!$this->penalty_enabled) return;

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getNotProcessed();

    foreach ($schedules as $schedule) {
      foreach ($schedule->getUsers() as $user) {

        if (!$user->getConfirmed()) {
          $product = new \Club\ShopBundle\Entity\CartProduct();
          $product->setPrice($schedule->getPenalty());
          $product->setQuantity(1);
          $product->setType('team_fee');
          $product->setProductName($this->penalty_product_name);

          $this->order->createSimpleOrder($user->getUser(),$schedule->getLocation());
          $this->order->addSimpleProduct($product);
          $this->order->save();
        }
      }

      $schedule->setProcessed(true);
      $this->em->persist($schedule);
    }

    $this->em->flush();
  }
}
