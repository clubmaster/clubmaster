<?php

namespace Club\ShopBundle\Listener;

class OrderPaidListener
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function onOrderPaid(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        $order = $event->getOrder();

        foreach ($order->getProducts() as $orderProduct) {

            $product = $orderProduct->getProduct();
            $product->setQuantity($product->getQuantity()-$orderProduct->getQuantity());

            $this->em->persist($product);

        }

        $this->em->flush();
    }
}
