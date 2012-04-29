<?php

namespace Club\UserBundle\Helper;

class Application
{
  private $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function clearCache()
  {
    $realCacheDir = $this->container->getParameter('kernel.cache_dir');
    $oldCacheDir  = $realCacheDir.'_old';

    $kernel = $this->container->get('kernel');
    rename($realCacheDir, $oldCacheDir);

    $this->container->get('filesystem')->remove($oldCacheDir);
  }
}
