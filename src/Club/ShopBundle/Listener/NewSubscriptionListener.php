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
        $subscription->setActive(1);
        $subscription->setType('subscription');

        $start_date = isset($res['start_date']) ? new \DateTime($res['start_date']->getValue()) : new \DateTime();

        if (isset($res['start_date'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('start_date');
          $sub_attr->setValue($res['start_date']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $date = new \DateTime($res['start_date']->getValue());
          if ($date->getTimestamp() > time()) {
            $start_date = $date;
          } elseif (isset($res['auto_renewal'])) {
            if ($res['auto_renewal']->getValue() == 'A') {
              $start_date = new \DateTime();
            } elseif ($res['auto_renewal']->getValue() == 'Y') {
              $start_date = new \DateTime(date('Y-m-d',mktime(0,0,0,$date->format('n'),$date->format('j'),date('Y'))));
              if ($start_date->getTimestamp() < time()) {
                $start_date->add(new \DateInterval('P1Y'));
              }
            }
          }
        }
        $subscription->setStartDate($start_date);

        if (isset($res['expire_date'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('expire_date');
          $sub_attr->setValue($res['expire_date']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $subscription->setExpireDate(new \DateTime($res['expire_date']->getValue()));
          if (isset($res['auto_renewal'])) {
            if ($res['auto_renewal']->getValue() == 'Y') {
              $date1 = new \DateTime($res['start_date']->getValue());
              $interval = $date1->diff(new \DateTime($res['expire_date']->getValue()));
              $expire_date = new \DateTime($start_date->format('Y-m-d H:i:s'));
              $expire_date->add($interval);

              $subscription->setExpireDate($expire_date);
            }
          }
        }

        if (isset($res['time_interval'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('time_interval');
          $sub_attr->setValue($res['time_interval']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $expire_date = new \DateTime($subscription->getStartDate()->format('Y-m-d H:i:s'));
          $expire_date->add(new \DateInterval('P'.$res['time_interval']->getValue()));
          $subscription->setExpireDate($expire_date);
        }

        if (isset($res['ticket'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('ticket');
          $sub_attr->setValue($res['ticket']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);

          $subscription->setType('ticket');
        }
        if (isset($res['auto_renewal'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('auto_renewal');
          $sub_attr->setValue($res['auto_renewal']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);
        }
        if (isset($res['allowed_pauses'])) {
          $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
          $sub_attr->setSubscription($subscription);
          $sub_attr->setAttributeName('allowed_pauses');
          $sub_attr->setValue($res['allowed_pauses']->getValue());
          $subscription->addSubscriptionAttributes($sub_attr);
          $this->em->persist($sub_attr);
        }
        if (isset($res['location'])) {
          $ids = preg_split("/,/", $res['location']->getValue());
          foreach ($ids as $id) {
            $location = $this->em->find('ClubUserBundle:Location', $id);
            $subscription->addLocation($location);
          }
        }

        $this->em->persist($subscription);
      }
    }

    $this->em->flush();
  }
}
