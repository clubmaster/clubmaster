<?php

namespace Club\InstallerBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Redirect
{
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function onKernelRequest($event)
  {
    try {
      // if we can select a user, the system is already installed
      $em = $this->container->get('doctrine.orm.entity_manager');
      $user = $em->find('ClubUserBundle:User', 1);
    } catch (\Exception $e) {

      $path = $this->container->get('kernel')->getRootDir().'/installer';
      $request = $this->container->get('request');

      $url = $request->getBasePath().'/config.php';
      if (file_exists($path) && !preg_match("/^\/(installer|configurator)/", $request->getPathInfo())) {
        $event->setResponse(new RedirectResponse($url));
      }
    }
  }
}
