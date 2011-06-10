<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class GroupRecalcListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onGroupTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $groups = $this->em->getRepository('\Club\UserBundle\Entity\Group')->findBy(array(
      'group_type' => 'dynamic'
    ));

    foreach ($groups as $group) {
      $query = $this->em->getRepository('\Club\UserBundle\Entity\Group')->getDynamicQuery($group);
      $users = $query->getQuery()->getResult();

      foreach ($users as $user) {
        if (!$user->inGroup($group)) {
          $user->addGroup($group);
          $this->em->persist($user);
        }
      }
      $this->em->flush();
    }
  }
}
