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

    $role = $this->getReference('ROLE_SUPER_ADMIN');
    $group->addRole($role);

    $manager->persist($group);
    $manager->flush();
  }

  public function getOrder()
  {
    return 20;
  }
}
