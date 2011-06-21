<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCurrencyData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('Danish Krone');
    $currency->setCode('DKK');
    $currency->setSymbolRight('DK');
    $currency->setDecimalPlaces(2);
    $currency->setValue(1);

    $manager->persist($currency);
    $manager->flush();

    $this->addReference('currency-dkk',$currency);
  }

  public function getOrder()
  {
    return 5;
  }
}
