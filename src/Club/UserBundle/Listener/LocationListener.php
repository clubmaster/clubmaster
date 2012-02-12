<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocationListener
{
  protected $em;
  protected $security_context;
  protected $session;

  public function __construct($em, $security_context, $session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
  }

  public function onKernelRequest()
  {
    if ($this->session->get('location_id') == '') {
      $location = $this->em->createQueryBuilder()
        ->select('l')
        ->from('ClubUserBundle:Location', 'l')
        ->where('l.id > 1')
        ->orderBy('l.id')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

      $this->session->set('location_id', $location->getId());
    }
  }
}
