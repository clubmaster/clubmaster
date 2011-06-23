<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadVatData implements FixtureInterface
{
  public function load($manager)
  {
    $vat = new \Club\ShopBundle\Entity\Vat();
    $vat->setVatName('Tax free');
    $vat->setRate(0);

    $manager->persist($vat);
    $manager->flush();
  }
}
