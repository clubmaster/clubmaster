<?php

namespace Club\UserBundle\Fixtures;

class Load
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onFixturesInit()
  {
    $this->initCurrency();
    $this->initRole();
    $this->em->flush();

    $this->initGroup();
    $this->em->flush();
  }

  private function initRole()
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
    $roles[] = 'ROLE_TOURNAMENT_ADMIN';
    $roles[] = 'ROLE_SHOP_ADMIN';
    $roles[] = 'ROLE_TEAM_ADMIN';
    $roles[] = 'ROLE_MEDIA_ADMIN';
    $roles[] = 'ROLE_PASSKEY_ADMIN';
    $roles[] = 'ROLE_STAFF';

    foreach ($roles as $role) {
      $r = $this->em->getRepository('ClubUserBundle:Role')->findOneBy(array(
        'role_name' => $role
      ));

      if (!$r) {
        $rol = new \Club\UserBundle\Entity\Role();
        $rol->setRoleName($role);
        $this->em->persist($rol);
      }
    }
  }

  private function initGroup()
  {
    $groups = array(
      array(
        'name' => 'Super Administrators',
        'type' => 'static',
        'roles' => array(
          'ROLE_SUPER_ADMIN'
        )
      ),
      array(
        'name' => 'Event Managers',
        'type' => 'static',
        'roles' => array(
          'ROLE_EVENT_ADMIN'
        )
      ),
      array(
        'name' => 'Staff',
        'type' => 'static',
        'roles' => array(
          'ROLE_STAFF'
        )
      )
    );

    foreach ($groups as $group) {
      $r = $this->em->getRepository('ClubUserBundle:Group')->getOneGroupByRoles($group['roles']);

      if (!$r) {
        $g = new \Club\UserBundle\Entity\Group();
        $g->setGroupName($group['name']);
        $g->setGroupType($group['type']);

        foreach ($group['roles'] as $role) {
          $rol = $this->em->getRepository('ClubUserBundle:Role')->findOneBy(array(
            'role_name' => $role
          ));
          $g->addRole($rol);
        }
        $this->em->persist($g);
      }
    }
  }

  private function initCurrency()
  {
    $c = array(
      array(
        'code' => 'USD',
        'name' => 'US Dollar'
      ),
      array(
        'code' => 'EUR',
        'name' => 'Euro'
      ),
      array(
        'code' => 'DKK',
        'name' => 'Danish Krone'
      ),
    );

    foreach ($c as $currency) {
      $r = $this->em->getRepository('ClubUserBundle:Currency')->findOneBy(array(
        'code' => $currency['code']
      ));

      if (!$r) {
        $cur = new \Club\UserBundle\Entity\Currency();
        $cur->setCurrencyName($currency['name']);
        $cur->setCode($currency['code']);
        $this->em->persist($cur);
      }
    }
  }
}
