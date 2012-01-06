<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
  protected $test=0;
  protected $em;
  protected $security_context;
  protected $session;

  public function __construct($em,$security_context,$session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
  }

  public function onKernelRequest(GetResponseEvent $event)
  {
    if (!$this->test) {
      $this->test = 1;
    } else {
      return;
    }

    if (!$this->security_context->getToken())
      return;

    $user = $this->security_context->getToken()->getUser();
    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLocation()) {
      $location = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_location');
      $user->setLocation($location);

      $this->em->persist($user);
      $this->em->flush();
    }

    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLanguage()) {
      $language = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_language',$user->getLocation());
      $user->setLanguage($language);
      $this->session->setLocale($language->getCode());

      $this->em->persist($user);
      $this->em->flush();
    }

    if ($user->getLanguage()->getCode() != $this->session->getLocale())
      $this->session->setLocale($user->getLanguage()->getCode());

    $this->session->set('current_user',$user);
  }
}
