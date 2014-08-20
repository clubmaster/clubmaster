<?php

namespace Club\ShopBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ClubShopExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container,new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('listener.yml');

        $container->setParameter('club_shop.view_shop', $config['view_shop']);
        $container->setParameter('club_shop.coupon_account_number', $config['coupon_account_number']);
        $container->setParameter('club_shop.guest_account_number', $config['guest_account_number']);
        $container->setParameter('club_shop.voucher_text', $config['voucher_text']);
        $container->setParameter('club_shop.hide_categories', $config['hide_categories']);
    }
}
