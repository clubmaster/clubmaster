<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    $roles = array();
    $roles[] = 'ROLE_SUPER_ADMIN';
    $roles[] = 'ROLE_ADMIN';
    $roles[] = 'ROLE_EVENT_ADMIN';
    $roles[] = 'ROLE_STAFF';

    foreach ($roles as $role) {
      $r = new \Club\UserBundle\Entity\Role();
      $r->setRoleName($role);

      $this->addReference($role,$r);

      $manager->persist($r);
    }

    $manager->flush();
  }

  public function getOrder()
  {
    return 10;
  }
}
