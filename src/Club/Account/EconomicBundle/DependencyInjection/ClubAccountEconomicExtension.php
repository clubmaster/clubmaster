<?php

namespace Club\Account\EconomicBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClubAccountEconomicExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($config['enabled']) $loader->load('listener.yml');

        $container->setParameter('club_account_economic.enabled', $config['enabled']);
        $container->setParameter('club_account_economic.agreement', $config['agreement']);
        $container->setParameter('club_account_economic.username', $config['username']);
        $container->setParameter('club_account_economic.password', $config['password']);
        $container->setParameter('club_account_economic.economic_url', $config['economic_url']);
        $container->setParameter('club_account_economic.contraAccount', $config['contraAccount']);
        $container->setParameter('club_account_economic.cashbook', $config['cashbook']);
        $container->setParameter('club_account_economic.currency', $config['currency']);
    }
}
