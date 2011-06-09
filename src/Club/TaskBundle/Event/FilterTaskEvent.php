<?php

namespace Club\TaskBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterTaskEvent extends Event
{
  protected $task;

  public function __construct(\Club\TaskBundle\Entity\Task $task)
  {
    $this->task = $task;
  }

  public function getTask()
  {
    return $this->task;
  }
}
