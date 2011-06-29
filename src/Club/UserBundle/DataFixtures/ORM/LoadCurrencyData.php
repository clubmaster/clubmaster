<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadCurrencyData implements FixtureInterface
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
  }
}
