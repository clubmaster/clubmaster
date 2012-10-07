<?php

namespace Club\LogBundle\Listener;

class Cleanup
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onTaskCleanup(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
      $this->logs();
  }

  private function logs()
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubLogBundle:Log','l')
      ->where('l.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-2 month')))
      ->getQuery()
      ->getResult();
  }
}
