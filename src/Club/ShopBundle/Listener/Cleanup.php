<?php

namespace Club\ShopBundle\Listener;

class Cleanup
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onTaskCleanup(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubShopBundle:Cart','c')
      ->where('c.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-2 week')))
      ->getQuery()
      ->getResult();
  }
}
