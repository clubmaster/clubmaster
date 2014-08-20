<?php

namespace Club\ShopBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('club_shop');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
          ->children()
          ->scalarNode('view_shop')->isRequired()->end()
          ->scalarNode('coupon_account_number')->isRequired()->end()
          ->scalarNode('guest_account_number')->isRequired()->end()
          ->scalarNode('voucher_text')->isRequired()->end()
          ->scalarNode('hide_categories')->defaultValue(false)->end()
          ->end();

        return $treeBuilder;
    }
}
