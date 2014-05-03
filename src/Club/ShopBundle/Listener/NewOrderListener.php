<?php

namespace Club\ShopBundle\Listener;

class NewOrderListener
{
    protected $em;
    protected $club_shop_order;

    public function __construct($em, $club_shop_order)
    {
        $this->em = $em;
        $this->club_shop_order = $club_shop_order;
    }

    public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        $order = $event->getOrder();

        $status = new \Club\ShopBundle\Entity\OrderStatusHistory();
        $status->setOrder($order);
        $status->setOrderStatus($order->getOrderStatus());

        $this->em->persist($status);
        $this->em->flush();

        if ($order->getAmountLeft() == 0) {
            $this->club_shop_order
                ->setOrder($order)
                ->setPaid()
                ;
        }
    }
}
