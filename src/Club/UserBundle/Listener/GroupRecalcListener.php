<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class GroupRecalcListener
{
  protected $em;
  protected $user;

  public function __construct($em, $user)
  {
    $this->em = $em;
    $this->user = $user;
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

      $query = $this->em->getRepository('ClubUserBundle:User')->getByGroup($group);
      foreach ($users as $user) {
        $group->addUsers($user);
      }
    }

    $this->em->flush();
  }
}
