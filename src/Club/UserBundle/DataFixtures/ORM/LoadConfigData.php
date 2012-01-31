<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadConfigData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $configs = array();
    $configs[] = 'default_language';
    $configs[] = 'default_currency';
    $configs[] = 'default_location';
    $configs[] = 'email_sender_address';
    $configs[] = 'email_sender_name';

    foreach ($configs as $c) {
      $config = new \Club\UserBundle\Entity\Config();
      $config->setConfigKey($c);

      $this->addReference('config_'.$c,$config);
      $manager->persist($config);
    }

    $manager->flush();
  }

  public function getOrder()
  {
    return 5;
  }
}
