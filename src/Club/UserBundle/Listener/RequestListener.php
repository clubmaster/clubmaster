<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
  }
}
