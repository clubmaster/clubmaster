<?php

namespace Club\MailBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ClubMailExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yml');
    $loader->load('listener.yml');

    $container->setParameter('club_mail.default_sender_address', $config['default_sender_address']);
    $container->setParameter('club_mail.default_sender_name', $config['default_sender_name']);
    $container->setParameter('club_mail.send_system_mails', $config['send_system_mails']);
  }
}
