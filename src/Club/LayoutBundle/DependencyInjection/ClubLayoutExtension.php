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

    $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('twig.yml');
    $loader->load('form.yml');

    $container->setParameter('club_layout.logo_path', $config['logo_path']);
    $container->setParameter('club_layout.logo_url', $config['logo_url']);
    $container->setParameter('club_layout.logo_title', $config['logo_title']);
    $container->setParameter('club_layout.title', $config['title']);
  }
}
