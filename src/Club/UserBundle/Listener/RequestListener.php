<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
  protected $em;
  protected $session;

  public function __construct($em,$session)
  {
    $this->em = $em;
    $this->session = $session;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
    if (!$this->session->get('location_id')) {
      $location = $this->em->getRepository('\Club\UserBundle\Entity\Location')->getDefault();
      $this->session->set('location_id',$location->getId());
    }
  }
}
