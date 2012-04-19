<?php

namespace Club\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTaskData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Update dynamic groups');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('1D');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onGroupTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T1H');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onLogTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Renewal memberships');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T1H');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onAutoRenewalTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup login logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T1H');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onLoginAttemptTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Cleanup ban logs');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T1H');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onBanTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Send emails');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T5M');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onMailTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Process message queue');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T15M');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onMessageTask');
    $manager->persist($task);

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

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Process matches');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T15M');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onMatchTask');
    $manager->persist($task);

    $task = new \Club\TaskBundle\Entity\Task();
    $task->setTaskName('Booking cleanup');
    $task->setEnabled(1);
    $task->setLocked(0);
    $task->setNextRunAt(new \DateTime());
    $task->setTaskInterval('T1M');
    $task->setEvent('\Club\TaskBundle\Event\Events');
    $task->setMethod('onBookingCleanup');
    $manager->persist($task);

    $manager->flush();
  }
}
