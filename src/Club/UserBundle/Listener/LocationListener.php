<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocationListener
{
  protected $em;
  protected $session;

  public function __construct($em, $session)
  {
    $this->em = $em;
    $this->session = $session;
  }

  public function onKernelRequest()
  {
    try {
      if ($this->session->get('location_id')) return;

      $location = $this->em->getRepository('ClubUserBundle:Location')->getFirstLocation();
      if ($location) $this->session->set('location_id', $location->getId());
    } catch (\PDOException $e) {
    }
  }
}
