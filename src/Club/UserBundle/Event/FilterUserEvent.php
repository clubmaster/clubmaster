<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterUserEvent extends Event
{
    protected $user;
    protected $output;
    protected $password;
    protected $sendMail = true;

    public function __construct(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function appendOutput($output)
    {
        $this->output .= $output;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSendMail($sendMail)
    {
        $this->sendMail = $sendMail;
    }

    public function getSendMail()
    {
        return $this->sendMail;
    }
}
