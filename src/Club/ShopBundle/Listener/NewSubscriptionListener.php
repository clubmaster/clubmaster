<?php

namespace Club\ShopBundle\Listener;

class NewSubscriptionListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onOrderChange(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    if ($order->getOrderStatus()->getIsAccepted()) {
      $products = $order->getOrderProducts();

      foreach ($products as $product) {

        $res = array();
        foreach ($product->getOrderProductAttributes() as $attr) {
          $res[$attr->getAttributeName()] = $attr->getValue();
        }

        if (isset($res['Month'])) {
          $subscription = new \Club\ShopBundle\Entity\Subscription;
          $subscription->setOrder($order);
          $subscription->setUser($order->getUser());
          $subscription->setIsActive(1);

          $start_date = (isset($res['StartDate'])) ? new \DateTime($res['StartDate']) : new \DateTime();
          $subscription->setStartDate($start_date);

          if (isset($res['ExpireDate'])) {
            $expire_date = new \DateTime($res['ExpireDate']);
          } else {
            $expire_date = new \DateTime($start_date->format('Y-m-d'));
            $expire_date->add(new \DateInterval('P1Y'));
          }
          $subscription->setExpireDate($expire_date);

          $allowed_pauses = (isset($res['AllowedPauses'])) ? $res['AllowedPauses'] : 0;
          $subscription->setAllowedPauses($allowed_pauses);

          $auto_renewal = (isset($res['AutoRenewal'])) ? $res['AutoRenewal'] : 0;
          $subscription->setAutoRenewal($auto_renewal);

          if (isset($res['Location'])) {
            $locations = preg_split("/,/", $res['Location']);
            foreach ($locations as $location) {
              $l = $this->em->find('\Club\UserBundle\Entity\Location',$location);
              $subscription->addLocations($l);
            }
          }
          $this->em->persist($subscription);
        }

        if (isset($res['Ticket'])) {
          $ticket = new \Club\ShopBundle\Entity\TicketCoupon;
          $ticket->setOrder($order);
          $ticket->setTicket($attr->getValue());
          $ticket->setUser($order->getUser());

          $start_date = (isset($res['StartDate'])) ? new \DateTime($res['StartDate']) : new \DateTime();
          $ticket->setStartDate($start_date);

          if (isset($res['ExpireDate'])) {
            $expire_date = new \DateTime($res['ExpireDate']);
          } else {
            $expire_date = new \DateTime($start_date->format('Y-m-d'));
            $expire_date->add(new \DateInterval('P1Y'));
          }
          $ticket->setExpireDate($expire_date);

          if (isset($res['Location'])) {
            $locations = preg_split("/,/", $res['Location']);
            foreach ($locations as $location) {
              $l = $this->em->find('\Club\UserBundle\Entity\Location',$location);
              $ticket->addLocations($l);
            }
          }

          $this->em->persist($ticket);
        }

        $this->em->flush();
      }
    }

  }
}
