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

      $location = $this->em->createQueryBuilder()
        ->select('l')
        ->from('ClubUserBundle:Location', 'l')
        ->where('l.id > 1')
        ->orderBy('l.id')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

      if ($location) $this->session->set('location_id', $location->getId());
    } catch (\PDOException $e) {
    }
  }
}
