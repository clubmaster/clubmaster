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

    if (!$this->em->getRepository('ClubShopBundle:Order')->isFirstAccepted($order))
      return;

    foreach ($order->getProducts() as $product) {

      $res = array();
      foreach ($product->getOrderProductAttributes() as $attr) {
        $res[$attr->getAttributeName()] = $attr;
      }

      $subscription = new \Club\ShopBundle\Entity\Subscription;
      $subscription->setOrder($order);
      $subscription->setUser($order->getUser());
      $subscription->setIsActive(1);
      $subscription->setType('subscription');

      $start_date = isset($res['StartDate']) ? new \DateTime($res['StartDate']->getValue()) : new \DateTime();
      $subscription->setStartDate($start_date);

      if (isset($res['ExpireDate'])) {
        $subscription->setExpireDate(new \DateTime($res['ExpireDate']->getValue()));
      }

      if (isset($res['Month'])) {
        $expire_date = new \DateTime($subscription->getStartDate()->format('Y-m-d'));;
        $expire_date->add(new \DateInterval('P'.$res['Month']->getValue().'M'));
        $subscription->setExpireDate($expire_date);
      }

      if (isset($res['Ticket'])) {
        $subscription->setType('ticket');

        $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
        $sub_attr->setSubscription($subscription);
        $sub_attr->setAttributeName('Ticket');
        $sub_attr->setValue($res['Ticket']->getValue());
        $subscription->addSubscriptionAttributes($sub_attr);

        $this->em->persist($sub_attr);
      }
      if (isset($res['AutoRenewal'])) {
        $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
        $sub_attr->setSubscription($subscription);
        $sub_attr->setAttributeName('AutoRenewal');
        $sub_attr->setValue($res['AutoRenewal']->getValue());
        $subscription->addSubscriptionAttributes($sub_attr);

        $this->em->persist($sub_attr);
      }
      if (isset($res['AllowedPauses'])) {
        $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
        $sub_attr->setSubscription($subscription);
        $sub_attr->setAttributeName('AllowedPauses');
        $sub_attr->setValue($res['AllowedPauses']->getValue());
        $subscription->addSubscriptionAttributes($sub_attr);

        $this->em->persist($sub_attr);
      }

      if (isset($res['Location'])) {
        $locations = preg_split("/,/", $res['Location']->getValue());
        foreach ($locations as $location) {
          $l = $this->em->find('ClubUserBundle:Location',$location);
          $subscription->addLocations($l);
        }
      }

      $this->em->persist($subscription);
    }

    $this->em->flush();
  }
}
