<?php

namespace Club\UserBundle\Helper;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FailurePasswordHandler implements AuthenticationFailureHandlerInterface
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    $login = new \Club\UserBundle\Entity\LoginAttempt();
    $login->setUsername($request->get('_username'));
    $login->setSession($request->getSession()->getId());
    $login->setIpAddress($request->getClientIp());
    $login->setHostname(gethostbyaddr($request->getClientIp()));
    $login->setLoginFailed(1);

    $this->em->persist($login);
    $this->em->flush();

    return $this->redirect('login');
  }
}
