<?php

namespace Club\UserBundle\Listener;

class Cleanup
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onTaskCleanup(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
      $this->loginAttempts();
      $this->connections();
  }

  private function loginAttempts()
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubUserBundle:LoginAttempt','l')
      ->where('l.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-2 month')))
      ->getQuery()
      ->getResult();
  }

  private function connections()
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubUserBundle:Connection','c')
      ->where('c.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-1 year')))
      ->getQuery()
      ->getResult();
  }
}
