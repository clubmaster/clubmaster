<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadConfigData implements FixtureInterface
{
  public function load($manager)
  {
    $configs = array();
    $configs[] = 'account_default_income';
    $configs[] = 'account_default_vat';
    $configs[] = 'default_language';

    foreach ($configs as $c) {
      $config = new \Club\UserBundle\Entity\Config();
      $config->setConfigKey($c);

      $manager->persist($config);
    }

    $manager->flush();
  }
}
