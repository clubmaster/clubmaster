<?php

namespace Club\LogBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CleanupLogListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onLogTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubLogBundle:Log','l')
      ->where('l.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-2 month')))
      ->getQuery()
      ->getResult();
  }
}
