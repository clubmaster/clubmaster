<?php

namespace Club\UserBundle\Listener;


class CleanupLoginAttemptListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onLoginAttemptTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $res = $this->em->createQueryBuilder()
      ->delete('ClubUserBundle:LoginAttempt','l')
      ->where('l.created_at < ?1')
      ->setParameter(1,date('Y-m-d H:is:',strtotime('-2 month')))
      ->getQuery()
      ->getResult();
  }
}
