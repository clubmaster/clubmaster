<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $group = new \Club\UserBundle\Entity\Group();
    $group->setGroupName('Super Administrators');
    $group->setGroupType('static');
    $group->addRole($this->getReference('ROLE_SUPER_ADMIN'));
    $manager->persist($group);

    $group = new \Club\UserBundle\Entity\Group();
    $group->setGroupName('Event Managers');
    $group->setGroupType('static');
    $group->addRole($this->getReference('ROLE_EVENT_ADMIN'));
    $manager->persist($group);

    $manager->flush();
  }

  public function getOrder()
  {
    return 20;
  }
}
