<?php

namespace Club\BookingBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('club_booking');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
          ->children()
            ->scalarNode('enabled')->isRequired()->end()
            ->scalarNode('enable_guest')->isRequired()->end()
            ->scalarNode('num_book_guest_day')->isRequired()->end()
            ->scalarNode('num_book_guest_future')->isRequired()->end()
            ->scalarNode('num_book_same_partner_day')->isRequired()->end()
            ->scalarNode('num_book_same_partner_future')->isRequired()->end()
            ->scalarNode('num_book_day')->isRequired()->end()
            ->scalarNode('num_book_future')->isRequired()->end()
            ->scalarNode('cancel_minute_before')->isRequired()->end()
            ->scalarNode('cancel_minute_created')->isRequired()->end()
            ->scalarNode('booking_style')->isRequired()->end()
            ->scalarNode('auto_confirm')->isRequired()->end()
          ->end();

        return $treeBuilder;
    }
}
