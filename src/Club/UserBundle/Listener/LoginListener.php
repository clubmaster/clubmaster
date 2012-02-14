<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LoginListener
{
  protected $em;
  protected $security_context;
  protected $session;

  public function __construct($em, $security_context, $session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
  }

  public function onSecurityInteractiveLogin()
  {
    $user = $this->security_context->getToken()->getUser();

    $login = new \Club\UserBundle\Entity\LoginAttempt();
    $login->setUsername($user->getUsername());
    $login->setSession(session_id());
    if (isset($_SERVER['REMOTE_ADDR'])) {
      $login->setIpAddress($_SERVER['REMOTE_ADDR']);
      $login->setHostname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
    } else {
      $login->setIpAddress('127.0.0.1');
      $login->setHostname(gethostbyaddr('127.0.0.1'));
    }
    $login->setLoginFailed(0);

    $this->em->persist($login);
    $this->em->flush();

    $this->setLocation();
    $this->setLocale();
  }

  private function setLocale()
  {
    if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY') && ($locale = $this->security_context->getToken()->getUser()->getLocale()))
      $this->session->setLocale($locale);

    if ($this->session->getLocale())
      return;
  }

  private function setLocation()
  {
    if ($this->session->get('location_id')) return;

    $this->location = $this->em->getRepository('ClubUserBundle:Location')->getFirstLocation();
    if (!$this->location) return;

    $this->session->set('location_id', $this->location->getId());
    $this->session->set('location_name', $this->location->getLocationName());

    if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
      return;

    $user = $this->security_context->getToken()->getUser();

    if ($user instanceOf \Club\UserBundle\Entity\User) {
      $user->setLocation($this->location);
      $this->em->persist($user);
      $this->em->flush();
    }
  }

}
