<?php

namespace Club\ShopBundle\Listener;

class NewSubscriptionListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onOrderPay(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    foreach ($order->getProducts() as $prod) {
      if ($prod->getType() == 'subscription') {
        $this->createSubscription($order, $prod);
      }
    }
  }

  public function onOrderChange(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    if (!$this->em->getRepository('ClubShopBundle:Order')->isFirstAccepted($order))
      return;

    foreach ($order->getProducts() as $product) {

      if ($product->getType() == 'subscription') {
        $this->createSubscription($order, $product);
      }
    }

    $this->em->flush();
  }

  protected function createSubscription(\Club\ShopBundle\Entity\Order $order, \Club\ShopBundle\Entity\OrderProduct $product)
  {
    $res = array();
    foreach ($product->getOrderProductAttributes() as $attr) {
      $res[$attr->getAttributeName()] = $attr;
    }

    $subscription = new \Club\ShopBundle\Entity\Subscription;
    $subscription->setOrder($order);
    $subscription->setOrderProduct($product);
    $subscription->setUser($order->getUser());
    $subscription->setType('subscription');

    $start_date = isset($res['start_date']) ? new \DateTime($res['start_date']->getValue()) : new \DateTime();
    $subscription->setStartDate($start_date);

    foreach ($res as $res_key => $res_val) {
      switch ($res_key) {
      case 'start_date':
        $subscription = $this->addSubAttr($subscription, $res_key, $res_val->getValue());
        $date = new \DateTime($res['start_date']->getValue());

        if ($date->getTimestamp() > time()) {
          $start_date = $date;
        } elseif (isset($res['auto_renewal'])) {
          if ($res['auto_renewal']->getValue() == 'A') {
            $start_date = new \DateTime();
          }
        }

        $subscription->setStartDate($start_date);
        break;

      case 'expire_date':
        $subscription = $this->addSubAttr($subscription, $res_key, $res_val->getValue());
        $expire_date = new \DateTime($res['expire_date']->getValue());

        if (isset($res['auto_renewal'])) {
          if ($res['auto_renewal']->getValue() == 'Y') {
            $date1 = new \DateTime($res['start_date']->getValue());
            $interval = $date1->diff(new \DateTime($res['expire_date']->getValue()));

            $expire_date = new \DateTime($start_date->format('Y-m-d H:i:s'));
            $expire_date->add($interval);

            while ($expire_date->getTimestamp() < time()) {
              $start_date->add(new \DateInterval('P1Y'));
              $expire_date->add(new \DateInterval('P1Y'));
            }

            $subscription->setExpireDate($expire_date);
          }
        }

        $subscription->setExpireDate($expire_date);
        break;

      case 'time_interval':
        $subscription = $this->addSubAttr($subscription, $res_key, $res_val->getValue());

        $expire_date = new \DateTime($subscription->getStartDate()->format('Y-m-d H:i:s'));
        $expire_date->add(new \DateInterval('P'.$res['time_interval']->getValue()));
        $subscription->setExpireDate($expire_date);
        break;

      case 'location':
        $ids = preg_split("/,/", $res['location']->getValue());
        foreach ($ids as $id) {
          $location = $this->em->find('ClubUserBundle:Location', $id);
          $subscription->addLocation($location);
        }
        break;

      case 'ticket':
        $subscription->setType('ticket');
      default:
        $subscription = $this->addSubAttr($subscription, $res_key, $res_val->getValue());
        break;
      }
    }
    $this->em->persist($subscription);
  }

  protected function addSubAttr(\Club\ShopBundle\Entity\Subscription $subscription, $name, $value)
  {
    $sub_attr = new \Club\ShopBundle\Entity\SubscriptionAttribute();
    $sub_attr->setSubscription($subscription);
    $sub_attr->setAttributeName($name);
    $sub_attr->setValue($value);
    $subscription->addSubscriptionAttributes($sub_attr);
    $this->em->persist($sub_attr);

    return $subscription;
  }
}
