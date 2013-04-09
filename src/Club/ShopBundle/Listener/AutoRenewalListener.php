<?php

namespace Club\ShopBundle\Listener;

class AutoRenewalListener
{
    protected $em;
    protected $order;
    protected $cart;

    public function __construct($em, $order, $cart)
    {
        $this->em = $em;
        $this->order = $order;
        $this->cart = $cart;
    }

    public function onAutoRenewalTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        $sub_attrs = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->getExpiredAutoSubscriptions('after');
        foreach ($sub_attrs as $sub_attr) {
            $subscription = $sub_attr->getSubscription();

            $this->copySubscription($subscription);
            $this->em->persist($subscription);
        }

        $sub_attrs = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->getExpiredAutoSubscriptions('yearly');
        foreach ($sub_attrs as $sub_attr) {
            $subscription = $sub_attr->getSubscription();

            $date_str = $subscription->getStartDate()->format(date('Y').'-m-d H:i:s');
            $d = new \DateTime($date_str);

            if ($d < new \DateTime()) {
                $this->copySubscription($subscription);
                $this->em->persist($subscription);
            }
        }

        $subscriptions = $this->em->getRepository('ClubShopBundle:Subscription')->getEmptyTicketAutoRenewalSubscriptions();
        foreach ($subscriptions as $subscription) {
            $this->copySubscription($subscription);
        }

        $this->em->flush();
    }

    private function copySubscription($subscription)
    {
        $old_order = $subscription->getOrder();

        $attr = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->findOneBy(array(
            'subscription' => $subscription->getId(),
            'attribute_name' => 'auto_renewal'
        ));
        $attr->setAttributeName('renewed');

        $cart_product = $this->cart->makeCartProduct($subscription->getOrderProduct()->getProduct());
        $this->order->copyOrder($old_order);
        $this->order->addCartProduct($cart_product);
        $this->order->save();

        $this->em->persist($attr);
        $this->em->persist($subscription);
    }
}
