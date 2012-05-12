<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;

class ResetPassword
{
  protected $router;
  protected $security;
  protected $em;
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security = $container->get('security.context');
    $this->router = $container->get('router');
    $this->first = true;
  }

  public function onKernelRequest($event)
  {
    if ($this->first) {
      $request = $this->container->get('request');
      if (preg_match("/user\/reset$/", $request->getURI())) return;

      if ($this->security->getToken() && $this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
        $reset = $this->em->getRepository('ClubUserBundle:ResetPassword')->getByUser($this->security->getToken()->getUser());

        if ($reset) {
          $response = new RedirectResponse($this->router->generate('club_user_user_reset'));
          $event->setResponse($response);
        }
      }
      $this->first = false;
    }
  }
}
