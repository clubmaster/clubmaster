<?php

namespace Club\WeatherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClubWeatherExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if ($config['enabled']) {
            $loader->load('listener.yml');
        }

        $container->setParameter('club_weather.enabled', $config['enabled']);
        $container->setParameter('club_weather.latitude', $config['latitude']);
        $container->setParameter('club_weather.longtitude', $config['longtitude']);
        $container->setParameter('club_weather.key', $config['key']);
    }
}
