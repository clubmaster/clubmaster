<?php

namespace Club\ShopBundle\Listener;

class MenuListener
{
  private $router;
  private $security_context;
  private $translator;

  public function __construct($router, $security_context, $translator)
  {
    $this->router = $router;
    $this->security_context = $security_context;
    $this->translator = $translator;
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu['shop'] = array(
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
      ),
    );

    $event->setMenu($menu);
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu[] = array(
      'name' => $this->translator->trans('Shop'),
      'route' => $this->router->generate('shop')
    );

    if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
      $menu[] = array(
        'name' => $this->translator->trans('Order'),
        'route' => $this->router->generate('shop_order')
      );
      $menu[] = array(
        'name' => $this->translator->trans('Subscription'),
        'route' => $this->router->generate('shop_subscription')
      );
    }

    $event->setMenu($menu);
  }
}
