<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterOutputEvent extends Event
{
    protected $activities = array();
    protected $output = '';
    protected $user;

    public function __construct(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function appendActivities($activity, $key)
    {
        if (isset($this->activities[$key])) {
            $key++;
            $this->appendActivities($activity, $key);
        } else {
            $this->activities[$key] = $activity;
        }
    }

    public function setActivities($activities)
    {
        $this->activities = $activities;
    }

    public function getActivities()
    {
        krsort($this->activities);
        return $this->activities;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function getOutput()
    {
        return $this->output;
    }
}
