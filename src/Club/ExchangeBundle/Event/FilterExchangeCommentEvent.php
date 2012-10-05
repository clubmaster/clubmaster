<?php

namespace Club\ExchangeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterExchangeCommentEvent extends Event
{
    protected $exchange_comment;
    protected $user;

    public function __construct(\Club\ExchangeBundle\Entity\ExchangeComment $exchange_comment, \Club\UserBundle\Entity\User $user)
    {
        $this->exchange_comment = $exchange_comment;
        $this->user = $user;
    }

    public function getExchangeComment()
    {
        return $this->exchange_comment;
    }

    public function getUser()
    {
        return $this->user;
    }
}
