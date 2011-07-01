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
    $bans = $this->em->getRepository('ClubUserBundle:Ban')->findAllExpired();

    foreach ($bans as $ban) {
      if ($ban->getType() == 'user') {
        $user = $this->em->find('ClubUserBundle:User',$ban->getValue());
        $user->setLocked(0);

        $this->em->remove($ban);
        $this->em->persist($user);
      }
    }

    $this->em->flush();
  }
}
