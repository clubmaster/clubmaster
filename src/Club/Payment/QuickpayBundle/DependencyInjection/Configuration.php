<?php

namespace Club\Payment\QuickpayBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('club_payment_quickpay');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
          ->children()
            ->scalarNode('enabled')->isRequired()->end()
            ->scalarNode('controller')->isRequired()->end()
            ->scalarNode('merchant')->isRequired()->end()
            ->scalarNode('secret')->isRequired()->end()
            ->scalarNode('protocol')->isRequired()->end()
            ->scalarNode('language')->isRequired()->end()
            ->scalarNode('currency')->isRequired()->end()
            ->scalarNode('autocapture')->isRequired()->end()
            ->scalarNode('quickpay_url')->isRequired()->end()
            ->scalarNode('cardtypelock')->defaultValue(null)->end()
            ->scalarNode('autofee')->defaultValue('0')->end()
            ->scalarNode('testmode')->defaultValue('0')->end()
            ->scalarNode('splitpayment')->defaultValue('0')->end()
            ->scalarNode('testmode')->defaultValue('0')->end()
          ->end();

        return $treeBuilder;
    }
}
