<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CleanupBanListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onBanTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubUserBundle:Ban','b')
      ->where('b.expire_date > :date')
      ->setParameter('date',date('Y-m-d H:is:'))
      ->getQuery()
      ->getResult();
  }
}
