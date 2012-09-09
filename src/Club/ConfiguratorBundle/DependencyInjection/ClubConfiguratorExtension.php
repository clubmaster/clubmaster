<?php

namespace Club\ConfiguratorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * ClubConfiguratorExtension.
 *
 * @author Marc Weistroff <marc.weistroff@sensio.com>
 */
class ClubConfiguratorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('webconfigurator.xml');
    }

    public function getNamespace()
    {
        return 'http://symfony.com/schema/dic/symfony/sensiodistribution';
    }

    public function getAlias()
    {
        return 'club_configurator';
    }
}
