<?php

namespace Club\TeamBundle\Listener;

class TeamPenaltyListener
{
  private $em;
  private $minutes_before_team;
  private $penalty_enabled;
  private $order;
  private $penalty_product_name;

  public function __construct($em, $minutes_before_team, $penalty_enabled, $order, $penalty_product_name)
  {
    $this->em = $em;
    $this->minutes_before_team = $minutes_before_team;
    $this->penalty_enabled = $penalty_enabled;
    $this->order = $order;
    $this->penalty_product_name = $penalty_product_name;
  }

  public function onTeamPenalty(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $teams = $this->em->getRepository('ClubTeamBundle:Team')->getNotProcessed();

    foreach ($teams as $team) {
      foreach ($team->getUsers() as $user) {

        $last = clone $team->getFirstDate();
        $diff = new \DateInterval('PT'.$this->minutes_before_team.'M');
        $first = clone $team->getFirstDate()->sub($diff);

        $participant = $this->em->getRepository('ClubTeamBundle:Participant')->getUserInRange($user->getUser(), $first, $last);
        if (!count($participant)) {
          if ($this->penalty_enabled) {
            $product = new \Club\ShopBundle\Entity\CartProduct();
            $product->setPrice($team->getPenalty());
            $product->setQuantity(1);
            $product->setType('team_fee');
            $product->setProductName($this->penalty_product_name);

            $this->order->createSimpleOrder($user->getUser(),$team->getLocation());
            $this->order->addSimpleProduct($product);
            $this->order->save();
          }
        }
      }

      $team->setProcessed(true);
      $this->em->persist($team);
    }

    $this->em->flush();
  }
}
