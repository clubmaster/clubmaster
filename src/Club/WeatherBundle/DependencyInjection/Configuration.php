<?php

namespace Club\WeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('club_weather');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
            ->scalarNode('enabled')->isRequired()->end()
            ->scalarNode('appid')->isRequired()->end()
            ->scalarNode('location')->defaultNull()->end()
            ->scalarNode('lonlat')->defaultNull()->end()
            ->scalarNode('cityid')->defaultNull()->end()
            ->scalarNode('units')->defaultValue('metric')->end()
            ->scalarNode('locale')->defaultValue('en')->end()
            ->end();

        return $treeBuilder;
    }
}
