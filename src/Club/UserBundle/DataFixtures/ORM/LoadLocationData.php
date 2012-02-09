<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $location = new \Club\UserBundle\Entity\Location();
    $location->setLocationName('ClubMaster');
    $manager->persist($location);

    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig('default_language');
    $lc->setValue(1);
    $manager->persist($lc);

    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig('default_currency');
    $lc->setValue(1);
    $manager->persist($lc);

    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig('default_location');
    $lc->setValue(2);
    $manager->persist($lc);

    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig('email_sender_address');
    $lc->setValue('noreply@clubmaster.dk');
    $manager->persist($lc);

    $lc = new \Club\UserBundle\Entity\LocationConfig();
    $lc->setLocation($location);
    $lc->setConfig('email_sender_name');
    $lc->setValue('ClubMaster');
    $manager->persist($lc);

    $manager->flush();
  }

  public function getOrder()
  {
    return 100;
  }
}
