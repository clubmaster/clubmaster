<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
    if (!$this->security_context->getToken()) return;

    $user = $this->security_context->getToken()->getUser();
    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLocation()) {
      $location = $this->em->getRepository('\Club\UserBundle\Entity\Location')->getDefault();
      $user->setLocation($location);

      $this->em->persist($user);
      $this->em->flush();
    }
  }
}
