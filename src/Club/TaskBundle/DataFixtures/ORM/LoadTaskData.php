<?php

namespace Club\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadTaskData implements FixtureInterface
{
  public function load($manager)
  {
    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Update dynamic groups');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onGroupTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onLogTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Renewal memberships');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onAutoRenewalTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup login logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onLoginAttemptTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup ban logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('onBanTask');
    $manager->persist($task);

    $manager->flush();
  }
}
