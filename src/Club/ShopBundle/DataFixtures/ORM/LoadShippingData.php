<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadShippingData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $shipping = new \Club\ShopBundle\Entity\Shipping();
    $shipping->setShippingName('Free shipping');
    $shipping->setDescription('Free shipping');
    $shipping->setPrice(0);

    $manager->persist($shipping);
    $manager->flush();
  }
}
