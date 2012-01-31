<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCurrencyData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('US Dollar');
    $currency->setCode('USD');
    $manager->persist($currency);

    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('Euro');
    $currency->setCode('EUR');
    $manager->persist($currency);

    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('Danish Krone');
    $currency->setCode('DKK');
    $manager->persist($currency);

    $manager->flush();
  }
}
