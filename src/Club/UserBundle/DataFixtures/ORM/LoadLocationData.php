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

    $config = $this->getReference('config_account_default_income');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config);
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_account_default_vat');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config);
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_default_language');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config);
    $lc->setValue(1);
    $manager->persist($lc);

    $config = $this->getReference('config_default_currency');
    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig($config);
    $lc->setValue(1);
    $manager->persist($lc);

    $manager->persist($location);
    $manager->flush();
  }

  public function getOrder()
  {
    return 100;
  }
}
