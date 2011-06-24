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

  public function onCoreRequest(GetResponseEvent $event)
  {
    if ($this->security_context->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
      return;

    $user = $this->security_context->getToken()->getUser();
    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLocation()) {
      $location = $this->em->getRepository('ClubUserBundle:Location')->getDefault();
      $user->setLocation($location);

      $this->em->persist($user);
      $this->em->flush();
    }

    if ($user instanceOf \Club\UserBundle\Entity\User && !$user->getLanguage()) {
      $config = $this->em->getRepository('ClubUserBundle:LocationConfig')->getByKey($user->getLocation(),'default_language');
      $language = $this->em->getRepository('ClubUserBundle:Language')->findOneBy(array(
        'code' => $config->getValue()
      ));
      $user->setLanguage($language);
      $this->session->setLocale($config->getValue());

      $this->em->persist($user);
      $this->em->flush();
    }
  }
}
