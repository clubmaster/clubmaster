<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
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
    if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
      return;

    $user = $this->security_context->getToken()->getUser();
    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLocation()) {
      $config = $this->em->getRepository('ClubUserBundle:LocationConfig')->getByKey('default_location');
      $location = $this->em->find('ClubUserBundle:Location',$config->getValue());
      $user->setLocation($location);

      $this->em->persist($user);
      $this->em->flush();
    }

    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLanguage()) {
      $config = $this->em->getRepository('ClubUserBundle:LocationConfig')->getByKey('default_language',$user->getLocation());
      $language = $this->em->find('ClubUserBundle:Language',$config->getValue());
      $user->setLanguage($language);
      $this->session->setLocale($config->getValue());

      $this->em->persist($user);
      $this->em->flush();
    }

    $this->session->set('current_user',$user);
  }
}
