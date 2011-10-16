<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $location = new \Club\UserBundle\Entity\Location();
    $location->setLocationName('ClubMaster');
    $manager->persist($location);

    $config = $this->getReference('config_account_default_cash');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_account_default_income');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(3);
    $manager->persist($lc);

    $config = $this->getReference('config_account_default_discount');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(4);
    $manager->persist($lc);

    $config = $this->getReference('config_default_language');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_default_currency');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_default_location');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue(2);
    $manager->persist($lc);

    $config = $this->getReference('config_email_sender_address');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue('noreply@clubmaster.dk');
    $manager->persist($lc);

    $config = $this->getReference('config_email_sender_name');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config->getConfigKey());
    $lc->setValue('ClubMaster');
    $manager->persist($lc);

    $manager->flush();
  }

  public function getOrder()
  {
    return 100;
  }
}
