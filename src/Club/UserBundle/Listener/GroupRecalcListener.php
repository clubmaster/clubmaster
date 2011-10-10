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

    $res = array();
    foreach ($this->em->getRepository('ClubUserBundle:User')->findAll() as $user) {
      $groups = $this->em->getRepository('ClubUserBundle:User')->getGroupsByUser($user);
      foreach ($groups as $group) {
        $group->addUsers($user);
        $res[$group->getId().'_'.$user->getId()] = 1;
      }
    }

    foreach ($groups as $group) {
      foreach ($group->getUsers() as $user) {
        if (!isset($res[$group->getId().'_'.$user->getId()]))
          $group->getUsers()->removeElement($user);
      }
    }

    $this->em->flush();
  }
}
