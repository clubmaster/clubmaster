<?php

namespace Club\TeamBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClubTeamExtension extends Extension
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

        $container->setParameter('club_team.enabled', $config['enabled']);
        $container->setParameter('club_team.future_occurs', $config['future_occurs']);
        $container->setParameter('club_team.minutes_before_schedule', $config['minutes_before_schedule']);
        $container->setParameter('club_team.minutes_after_schedule', $config['minutes_after_schedule']);
        $container->setParameter('club_team.penalty_enabled', $config['penalty_enabled']);
        $container->setParameter('club_team.cancel_minute_before', $config['cancel_minute_before']);
        $container->setParameter('club_team.cancel_minute_created', $config['cancel_minute_created']);
        $container->setParameter('club_team.num_team_day', $config['num_team_day']);
        $container->setParameter('club_team.num_team_future', $config['num_team_future']);
        $container->setParameter('club_team.penalty_product_name', $config['penalty_product_name']);
    }
}
