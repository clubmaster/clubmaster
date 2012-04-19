<?php

namespace Club\ShopBundle\Fixtures;

class Load
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onFixturesInit()
  {
    $this->initOrderStatus();
    $this->initShipping();

    $this->em->flush();
  }

  private function initOrderStatus()
  {
    $statuses = array(
      array(
        'name' => 'Pending',
        'paid' => 0,
        'delivered' => 0,
        'cancelled' => 0,
        'priority' => 1
      ),
      array(
        'name' => 'Processing',
        'paid' => 0,
        'delivered' => 0,
        'cancelled' => 0,
        'priority' => 2
      ),
      array(
        'name' => 'Paid',
        'paid' => 1,
        'delivered' => 0,
        'cancelled' => 0,
        'priority' => 3
      ),
      array(
        'name' => 'Delivered',
        'paid' => 0,
        'delivered' => 1,
        'cancelled' => 0,
        'priority' => 4
      ),
      array(
        'name' => 'Cancelled',
        'paid' => 0,
        'delivered' => 0,
        'cancelled' => 1,
        'priority' => 5
      )
    );

    foreach ($statuses as $status) {
      $r = $this->em->getRepository('ClubShopBundle:OrderStatus')->findOneBy(array(
        'paid' => $status['paid'],
        'delivered' => $status['delivered'],
        'cancelled' => $status['cancelled']
      ));

      if (!$r) {
        $s = new \Club\ShopBundle\Entity\OrderStatus();
        $s->setStatusName($status['name']);
        $s->setPaid($status['paid']);
        $s->setDelivered($status['delivered']);
        $s->setCancelled($status['cancelled']);
        $s->setPriority($status['priority']);
        $this->em->persist($s);
      }
    }
  }

  private function initShipping()
  {
    $r = $this->em->getRepository('ClubShopBundle:OrderStatus')->findAll();
    if (!$r) {
      $shippings = array(
        array(
          'name' => 'Free shipping',
          'description' => 'Free shipping',
          'price' => 0
        )
      );

      foreach ($shippings as $shipping) {
        $s = new \Club\ShopBundle\Entity\Shipping();
        $s->setShippingName($shipping['name']);
        $s->setDescription($shipping['description']);
        $s->setPrice($shipping['price']);
        $this->em->persist($s);
      }
    }
  }
}
