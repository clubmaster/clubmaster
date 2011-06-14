<?php

namespace Club\UserBundle\Helper;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SuccessPasswordHandler implements AuthenticationSuccessHandlerInterface
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token)
  {
    $login = new \Club\UserBundle\Entity\LoginAttempt();
    $login->setUsername($request->get('_username'));
    $login->setSession($request->getSession()->getId());
    $login->setIpAddress($request->getClientIp());
    $login->setHostname(gethostbyaddr($request->getClientIp()));
    $login->setLoginFailed(0);

    $this->em->persist($login);
    $this->em->flush();

    return new RedirectResponse('.');
  }
}
