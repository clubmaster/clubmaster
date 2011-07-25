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
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onGroupTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onLogTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Renewal memberships');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onAutoRenewalTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup login logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onLoginAttemptTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup ban logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onBanTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Send emails');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('+1 hour');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onMailTask');
    $manager->persist($task);

    $manager->flush();
  }
}
