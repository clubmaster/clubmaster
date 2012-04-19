<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $roles = array();
    $roles[] = 'ROLE_SUPER_ADMIN';
    $roles[] = 'ROLE_ADMIN';
    $roles[] = 'ROLE_BLOG_ADMIN';
    $roles[] = 'ROLE_BOOKING_ADMIN';
    $roles[] = 'ROLE_EVENT_ADMIN';
    $roles[] = 'ROLE_MEMBER_ADMIN';
    $roles[] = 'ROLE_MESSAGE_ADMIN';
    $roles[] = 'ROLE_RANKING_ADMIN';
    $roles[] = 'ROLE_SHOP_ADMIN';
    $roles[] = 'ROLE_TEAM_ADMIN';
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
