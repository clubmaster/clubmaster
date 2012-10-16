<?php

namespace Club\ShopBundle\Listener;

class Migrate
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function onVersionMigrate(\Club\InstallerBundle\Event\FilterVersionEvent $event)
    {
        if ($event->getVersion()->getVersion() != '20121016161300') {
            // fit to this version only
            return;
        }

        $products = $this->em->getRepository('ClubShopBundle:Product')->findAll();

        foreach ($products as $product) {
            $product->setActive(true);
            $this->em->persist($product);
        }
    }
}
