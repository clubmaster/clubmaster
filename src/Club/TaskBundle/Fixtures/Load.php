<?php

namespace Club\TaskBundle\Fixtures;

class Load
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onFixturesInit()
  {
    $this->initTask();

    $this->em->flush();
  }

  private function initTask()
  {
    $tasks = array(
      array(
        'name' => 'Update dynamic groups',
        'interval' => '1D',
        'method' => 'onGroupTask'
      ),
      array(
        'name' => 'Renewal memberships',
        'interval' => 'T1H',
        'method' => 'onAutoRenewalTask'
      ),
      array(
        'name' => 'Send emails',
        'interval' => 'T1M',
        'method' => 'onMailTask'
      ),
      array(
        'name' => 'Process message queue',
        'interval' => 'T15M',
        'method' => 'onMessageTask'
      ),
      array(
        'name' => 'Generate new team schedules',
        'interval' => '1D',
        'method' => 'onTeamTask'
      ),
      array(
        'name' => 'Create team penalty',
        'interval' => 'T1H',
        'method' => 'onTeamPenalty'
      ),
      array(
        'name' => 'Process matches',
        'interval' => 'T15M',
        'method' => 'onMatchTask'
      ),
      array(
        'name' => 'Booking cleanup',
        'interval' => 'T1M',
        'method' => 'onBookingCleanup'
      ),
      array(
        'name' => 'Task cleanup',
        'interval' => 'T1M',
        'method' => 'onTaskCleanup'
      )
    );

    foreach ($tasks as $task) {
      $r = $this->em->getRepository('ClubTaskBundle:Task')->findOneBy(array(
        'method' => $task['method']
      ));

      if (!$r) {
        $t = new \Club\TaskBundle\Entity\Task();
        $t->setTaskName($task['name']);
        $t->setEnabled(1);
        $t->setLocked(0);
        $t->setNextRunAt(new \DateTime());
        $t->setTaskInterval($task['interval']);
        $t->setEvent('\Club\TaskBundle\Event\Events');
        $t->setMethod($task['method']);
        $this->em->persist($t);
      }
    }
  }
}
