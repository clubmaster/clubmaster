<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadRoleData implements FixtureInterface
{
  public function load($manager)
  {
    $roles = array();
    $roles[] = 'ROLE_ADMIN';

    foreach ($roles as $role) {
      $r = new \Club\UserBundle\Entity\Role();
      $r->setRoleName($role);

      $manager->persist($r);
    }

    $manager->flush();
  }
}
