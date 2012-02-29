<?php

namespace Club\DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterDashboardEvent extends Event
{
  protected $output;

  public function setOutput($output)
  {
    $this->output = $output;
  }

  public function getOutput()
  {
    return $this->output;
  }
}
