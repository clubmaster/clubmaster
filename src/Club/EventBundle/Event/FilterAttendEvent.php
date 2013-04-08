<?php

namespace Club\EventBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterAttendEvent extends Event
{
    protected $event;

    public function __construct(\Club\EventBundle\Entity\Attend $attend)
    {
        $this->attend = $attend;
    }

    public function getAttend()
    {
        return $this->attend;
    }
}
