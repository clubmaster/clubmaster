<?php

namespace Club\InstallerBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class Redirect
{
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function onKernelRequest()
  {
    return;
    $path = $this->container->get('kernel')->getRootDir().'/config/parameters.ini';
    $request = $this->container->get('request');

    if (!file_exists($path) && !preg_match("/^installer/", $request->getPathInfo())) {
    }
  }
}
