<?php

namespace Club\Payment\QuickpayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClubPaymentQuickpayExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($config['enabled']) $loader->load('listener.yml');

        $container->setParameter('club_payment_quickpay.enabled', $config['enabled']);
        $container->setParameter('club_payment_quickpay.controller', $config['controller']);
        $container->setParameter('club_payment_quickpay.merchant', $config['merchant']);
        $container->setParameter('club_payment_quickpay.secret', $config['secret']);
        $container->setParameter('club_payment_quickpay.protocol', $config['protocol']);
        $container->setParameter('club_payment_quickpay.language', $config['language']);
        $container->setParameter('club_payment_quickpay.currency', $config['currency']);
        $container->setParameter('club_payment_quickpay.autocapture', $config['autocapture']);
        $container->setParameter('club_payment_quickpay.cardtypelock', $config['cardtypelock']);
        $container->setParameter('club_payment_quickpay.autofee', $config['autofee']);
        $container->setParameter('club_payment_quickpay.testmode', $config['testmode']);
        $container->setParameter('club_payment_quickpay.splitpayment', $config['splitpayment']);
        $container->setParameter('club_payment_quickpay.quickpay_url', $config['quickpay_url']);
        $container->setParameter('club_payment_quickpay.testmode', $config['testmode']);
    }
}
