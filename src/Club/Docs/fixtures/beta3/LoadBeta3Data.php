<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadBeta3Data implements FixtureInterface
{
  public function load($manager)
  {
    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup ban logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onBanTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Send emails');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onMailTask');
    $manager->persist($task);

    $attributes = array();
    $attributes[] = 'name';
    $attributes[] = 'member_number';

    foreach ($attributes as $attr) {
      $a = new \Club\UserBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
