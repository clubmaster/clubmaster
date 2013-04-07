<?php

namespace Club\EventBundle\Listener;

class ShopListener
{
    private $container;
    private $em;
    private $event_dispatcher;
    private $event;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->event_dispatcher = $container->get('event_dispatcher');
        $this->event = $container->get('club_event.event');
    }

    public function onOrderPaid(\Club\ShopBundle\Event\FilterOrderEvent $event)
    {
        foreach ($event->getOrder()->getOrderProducts() as $product) {
            if ($product->getType() == 'event') {
                if (preg_match("/#(\d+)$/", $product->getProductName(), $o)) {
                    $e = $this->em->find('ClubEventBundle:Event', $o[1]);

                    if ($e) {
                        $this->event->attend($e, $event->getOrder()->getUser());
                    }
                }
            }
        }
    }
}
