<?php

namespace Club\WelcomeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterCommentEvent extends Event
{
    protected $comment;

    public function __construct(\Club\WelcomeBundle\Entity\Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
