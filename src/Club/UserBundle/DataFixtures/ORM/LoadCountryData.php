<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadCountryData implements FixtureInterface
{
  public function load($manager)
  {
    $countries = array();
    $countries[] = 'Denmark';
    $countries[] = 'Sweden';
    $countries[] = 'Norway';
    $countries[] = 'Germany';
    $countries[] = 'Finland';

    foreach ($countries as $c) {
      $country = new \Club\UserBundle\Entity\Country();
      $country->setCountry($c);

      $manager->persist($country);
    }

    $manager->flush();
  }
}
