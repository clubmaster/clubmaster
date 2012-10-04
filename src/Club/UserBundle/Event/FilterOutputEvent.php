<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterOutputEvent extends Event
{
    protected $output;
    protected $activities = array();
    protected $user;

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
        sort($this->activities);
        return $this->activities;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
