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

      if (count($product->getOrderProductAttributes())) {
        $res = array();
        foreach ($product->getOrderProductAttributes() as $attr) {
          $res[$attr->getAttributeName()] = $attr;
        }

        $subscription = new \Club\ShopBundle\Entity\Subscription;
        $subscription->setOrder($order);
        $subscription->setOrderProduct($product);
        $subscription->setUser($order->getUser());
        $subscription->setIsActive(1);
        $subscription->setType('subscription');

        $start_date = isset($res['StartDate']) ? new \DateTime($res['StartDate']->getValue()) : new \DateTime();

        if (isset($res['StartDate'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('StartDate');
          $sub_attr->setValue($res['StartDate']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $date = new \DateTime($res['StartDate']->getValue());
          if ($date->getTimestamp() > time()) {
            $start_date = $date;
          } elseif (isset($res['AutoRenewal'])) {
            if ($res['AutoRenewal']->getValue() == 'A') {
              $start_date = new \DateTime();
            } elseif ($res['AutoRenewal']->getValue() == 'Y') {
              $start_date = new \DateTime(date('Y-m-d',mktime(0,0,0,$date->format('n'),$date->format('j'),date('Y'))));
              if ($start_date->getTimestamp() < time()) {
                $start_date->add(new \DateInterval('P1Y'));
              }
            }
          }
        }
        $subscription->setStartDate($start_date);

        if (isset($res['ExpireDate'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('ExpireDate');
          $sub_attr->setValue($res['ExpireDate']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $subscription->setExpireDate(new \DateTime($res['ExpireDate']->getValue()));
          if (isset($res['AutoRenewal'])) {
            if ($res['AutoRenewal']->getValue() == 'Y') {
              $date1 = new \DateTime($res['StartDate']->getValue());
              $interval = $date1->diff(new \DateTime($res['ExpireDate']->getValue()));
              $expire_date = new \DateTime($start_date->format('Y-m-d'));
              $expire_date->add($interval);

              $subscription->setExpireDate($expire_date);
            }
          }
        }

        if (isset($res['Month'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('Month');
          $sub_attr->setValue($res['Month']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $expire_date = new \DateTime($subscription->getStartDate()->format('Y-m-d'));;
          $expire_date->add(new \DateInterval('P'.$res['Month']->getValue().'M'));
          $subscription->setExpireDate($expire_date);
        }

        if (isset($res['Ticket'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('Ticket');
          $sub_attr->setValue($res['Ticket']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $subscription->setType('ticket');
        }
        if (isset($res['AutoRenewal'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('AutoRenewal');
          $sub_attr->setValue($res['AutoRenewal']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);
        }
        if (isset($res['Lifetime'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('Lifetime');
          $sub_attr->setValue($res['Lifetime']->getValue());
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
            $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
            $sub_attr->setSubscription($subscription);
            $sub_attr->setAttributeName('Location');
            $sub_attr->setValue($location);
            $subscription->addSubscriptionAttributes($sub_attr);
            $this->em->persist($sub_attr);
          }
        }

        $this->em->persist($subscription);
      }
    }

    $this->em->flush();
  }
}
