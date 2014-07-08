<?php

namespace Club\LogBundle\Listener;

class NewOrderListener
{
    protected $em;
    protected $security_context;

    public function __construct($em,$security_context)
    {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        $order = $event->getOrder();

        $log = new \Club\LogBundle\Entity\Log();
        $log->setEvent('onShopOrder');
        $log->setSeverity('informational');
        $log->setLogType('shop');
        $log->setLog('Created a new order #'.$order->getId());

        if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
            $log->setUser($this->security_context->getToken()->getUser());

        $this->em->persist($log);
        $this->em->flush();
    }
}
