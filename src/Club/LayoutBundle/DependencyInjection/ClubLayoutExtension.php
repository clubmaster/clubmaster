<?php

namespace Club\LayoutBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ClubLayoutExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    //$loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));

    $container->setParameter('club_layout.title', $config['title']);
  }
}
