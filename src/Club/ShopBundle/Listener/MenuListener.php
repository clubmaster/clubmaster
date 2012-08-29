<?php

namespace Club\ShopBundle\Listener;

class MenuListener
{
    private $router;
    private $security_context;
    private $translator;
    private $container;

    public function __construct($router, $security_context, $translator, $container)
    {
        $this->router = $router;
        $this->security_context = $security_context;
        $this->translator = $translator;
        $this->container = $container;
    }

    public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        if ($this->security_context->isGranted('ROLE_TEAM_ADMIN')) {

            $menu[22] = array(
                'name' => $this->translator->trans('Shop'),
                'route' => $this->router->generate('admin_shop_product'),
                'items' => array(
                    array(
                        'name' => $this->translator->trans('Product'),
                        'route' => $this->router->generate('admin_shop_product')
                    ),
                    array(
                        'name' => $this->translator->trans('Category'),
                        'route' => $this->router->generate('admin_shop_category')
                    ),
                    array(
                        'name' => $this->translator->trans('Order'),
                        'route' => $this->router->generate('admin_shop_order')
                    ),
                    array(
                        'name' => $this->translator->trans('Coupon'),
                        'route' => $this->router->generate('club_shop_admincoupon_index')
                    ),
                    array(
                        'name' => $this->translator->trans('Special Price'),
                        'route' => $this->router->generate('club_shop_adminspecial_index')
                    ),
                    array(
                        'name' => $this->translator->trans('Payment Method'),
                        'route' => $this->router->generate('admin_shop_payment_method')
                    ),
                    array(
                        'name' => $this->translator->trans('Shipping'),
                        'route' => $this->router->generate('admin_shop_shipping')
                    ),
                    array(
                        'name' => $this->translator->trans('Order status'),
                        'route' => $this->router->generate('club_shop_adminorderstatus_index')
                    ),
                ),
            );

            $event->appendItem($menu);
        }
    }

    public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        if ($this->container->getParameter('club_shop.view_shop')) {
            $menu[30] = array(
                'name' => $this->translator->trans('Shop'),
                'route' => $this->router->generate('shop')
            );
            $event->appendItem($menu);
        }
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu = array();

        $menu[45] = array(
            'name' => $this->translator->trans('Shop'),
            'route' => $this->router->generate('club_request_playermarket_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/basket.png',
            'text' => 'Gå op opdagelse i butikken, her finder du alt klubben tilbyder af abonnementer og services.'
        );
        $event->appendItemDash($menu);
    }
}
