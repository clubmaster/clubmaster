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
      foreach ($group->getUsers() as $user) {
        $this->em->remove($user);
      }
      $users = $this->em->getRepository('\Club\UserBundle\Entity\Group')->getDynamicQuery($group)->getQuery()->getResult();
      $group->setUsers($users);

      $this->em->persist($group);
    }


    $this->em->flush();
  }
}
