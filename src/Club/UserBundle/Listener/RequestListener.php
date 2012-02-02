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
  protected $location;

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

    $this->setLocation();
    $this->setLocale();
  }

  private function setLocale()
  {
    if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY') && ($language = $this->security_context->getToken()->getUser()->getLanguage()))
      $this->session->setLocale($language->getCode());

    if ($this->session->getLocale())
      return;

    $language = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_language',$this->location);
    $this->session->setLocale($language->getCode());

    $user = $this->security_context->getToken()->getUser();
    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLanguage()) {
      $user->setLanguage($language);

      $this->em->persist($user);
      $this->em->flush();
    }
  }

  private function setLocation()
  {
    if ($this->session->get('location_id')) return;

    $this->location = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_location');
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
