<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadTasksBeta3Data implements FixtureInterface
{
  public function load($manager)
  {
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
