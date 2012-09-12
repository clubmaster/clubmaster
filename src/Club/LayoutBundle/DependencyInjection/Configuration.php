<?php

namespace Club\LayoutBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('club_layout');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
          ->children()
          ->scalarNode('logo_path')->defaultValue('bundles/clublayout/images/logo.png')->end()
          ->scalarNode('logo_url')->defaultValue('homepage')->end()
          ->scalarNode('logo_title')->defaultValue('ClubMaster')->end()
          ->scalarNode('title')->isRequired()->end()
          ->end();

        return $treeBuilder;
    }
}
