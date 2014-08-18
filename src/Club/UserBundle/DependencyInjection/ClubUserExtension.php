<?php

namespace Club\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ClubUserExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yml');
    $loader->load('listener.yml');
    $loader->load('twig.yml');

    $container->setParameter('club_user.default_country', $config['default_country']);
    $container->setParameter('club_user.welcome_mail_attachments', $config['welcome_mail_attachments']);
  }
}
