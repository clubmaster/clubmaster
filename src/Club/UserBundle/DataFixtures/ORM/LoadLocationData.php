<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $dk_location = new \Club\UserBundle\Entity\Location();
    $dk_location->setLocationName('Denmark');
    $dk_location->setCurrency($manager->merge($this->getReference('currency-dkk')));
    $manager->persist($dk_location);

    $aalb_location = new \Club\UserBundle\Entity\Location();
    $aalb_location->setLocationName('Aalborg');
    $aalb_location->setLocation($dk_location);
    $aalb_location->setCurrency($manager->merge($this->getReference('currency-dkk')));
    $manager->persist($aalb_location);

    $cph_location = new \Club\UserBundle\Entity\Location();
    $cph_location->setLocationName('Copenhagen');
    $cph_location->setLocation($dk_location);
    $cph_location->setCurrency($manager->merge($this->getReference('currency-dkk')));
    $manager->persist($cph_location);

    $location = new \Club\UserBundle\Entity\Location();
    $location->setLocationName('Aalborg Tennis Klub');
    $location->setLocation($aalb_location);
    $location->setCurrency($manager->merge($this->getReference('currency-dkk')));
    $manager->persist($location);

    $location = new \Club\UserBundle\Entity\Location();
    $location->setLocationName('Gug Tennis Klub');
    $location->setLocation($aalb_location);
    $location->setCurrency($manager->merge($this->getReference('currency-dkk')));
    $manager->persist($location);

    $manager->flush();
  }

  public function getOrder()
  {
    return 10;
  }
}
