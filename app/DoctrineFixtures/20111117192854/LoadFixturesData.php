<?php

namespace Application\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadFixturesData implements FixtureInterface
{
  public function load($manager)
  {
    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Generate new team schedules');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('1D');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onTeamTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Create team penalty');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('1D');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onTeamPenalty');
    $manager->persist($task);

    $roles = array();
    $roles[] = 'ROLE_STAFF';

    foreach ($roles as $role) {
      $r = new \Club\UserBundle\Entity\Role();
      $r->setRoleName($role);
      $manager->persist($r);
    }

    $attributes = array();
    $attributes[] = 'team';

    foreach ($attributes as $attr) {
      $a = new \Club\ShopBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $group = new \Club\UserBundle\Entity\Group();
    $group->setGroupName('Staff');
    $group->setGroupType('static');
    $manager->persist($group);

    $manager->flush();
  }
}
