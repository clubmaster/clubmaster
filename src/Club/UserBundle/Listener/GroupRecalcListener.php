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
    $groups = $this->em->getRepository('ClubUserBundle:Group')->findBy(array(
      'group_type' => 'dynamic'
    ));

    foreach ($groups as $group) {
      $users = $group->getUsers();
      foreach ($users as $user) {
        $group->getUsers()->removeElement($user);
      }

      $query = $this->em->getRepository('ClubUserBundle:Group')->getDynamicQuery($group);
      $users = $query->getQuery()->getResult();
      foreach ($users as $user) {
        $group->addUsers($user);
      }
    }

    $this->em->flush();
  }
}
