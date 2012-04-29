<?php

namespace Club\MailBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('club_mail');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
          ->children()
            ->scalarNode('default_sender_address')->isRequired()->end()
            ->scalarNode('default_sender_name')->isRequired()->end()
            ->scalarNode('mail_on_welcome')->isRequired()->end()
            ->scalarNode('mail_on_booking')->isRequired()->end()
            ->scalarNode('mail_on_order')->isRequired()->end()
          ->end();

        return $treeBuilder;
    }
}
