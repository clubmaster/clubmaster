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

  public function onGroupEdit(\Club\UserBundle\Event\FilterGroupEvent $event)
  {
    $group = $event->getGroup();
    $this->recalcUsers($group);
  }

  public function onGroupTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $groups = $this->em->getRepository('ClubUserBundle:Group')->findBy(array(
      'group_type' => 'dynamic'
    ));

    foreach ($groups as $group) {
      $this->recalcUsers($group);
    }
  }

  private function recalcUsers(\Club\UserBundle\Entity\Group $group)
  {
    if ($group->getGroupType() == 'static') return;

    $group->resetUsers();
    $this->em->persist($group);

    $users = $this->em->getRepository('ClubUserBundle:Group')->getDynamicUsers($group);
    $group->setUsers($users);
    $this->em->persist($group);
    $this->em->flush();
  }
}
