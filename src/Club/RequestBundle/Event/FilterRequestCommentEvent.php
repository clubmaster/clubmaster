<?php

namespace Club\RequestBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterRequestCommentEvent extends Event
{
  protected $request_comment;

  public function __construct(\Club\RequestBundle\Entity\RequestComment $request_comment)
  {
    $this->request_comment = $request_comment;
  }

  public function getRequestComment()
  {
    return $this->request_comment;
  }
}
