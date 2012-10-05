<?php

namespace Club\ExchangeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterExchangeCommentEvent extends Event
{
  protected $exchange_comment;

  public function __construct(\Club\ExchangeBundle\Entity\ExchangeComment $exchange_comment)
  {
    $this->exchange_comment = $exchange_comment;
  }

  public function getExchangeComment()
  {
    return $this->exchange_comment;
  }
}
