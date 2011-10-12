<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LoginListener
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onSecurityInteractiveLogin()
  {
    $user = $this->security_context->getToken()->getUser();

    $login = new \Club\UserBundle\Entity\LoginAttempt();
    $login->setUsername($user->getUsername());
    $login->setSession(session_id());
    $login->setIpAddress($_SERVER['REMOTE_ADDR']);
    $login->setHostname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
    $login->setLoginFailed(0);

    $this->em->persist($login);
    $this->em->flush();
  }
}
