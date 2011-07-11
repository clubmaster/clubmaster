<?php

namespace Club\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
  public function topMenuAction()
  {
    $menu = array();

    $menu[] = array(
      'name' => 'User',
      'route' => $this->generateUrl('user')
    );
    $menu[] = array(
      'name' => 'Shop',
      'route' => $this->generateUrl('shop')
    );
    $menu[] = array(
      'name' => 'Order',
      'route' => $this->generateUrl('shop_order')
    );
    $menu[] = array(
      'name' => 'Subscription',
      'route' => $this->generateUrl('shop_subscription')
    );
    $menu[] = array(
      'name' => 'Event',
      'route' => $this->generateUrl('event_event')
    );

    return $this->render('ClubMenuBundle:Default:topMenu.html.twig', array(
      'menu' => $menu
    ));
  }

  public function leftMenuAction()
  {
    $menu = array(
      array(
        'name' => 'User',
        'route' => $this->generateUrl('admin_user'),
        'items' => array(
          array(
            'name' => 'Location',
            'route' => $this->generateUrl('admin_location')
          ),
          array(
            'name' => 'Group',
            'route' => $this->generateUrl('admin_group')
          ),
          array(
            'name' => 'Currency',
            'route' => $this->generateUrl('admin_currency')
          ),
          array(
            'name' => 'Ban',
            'route' => $this->generateUrl('ban')
          ),
          array(
            'name' => 'Task',
            'route' => $this->generateUrl('admin_task')
          ),
          array(
            'name' => 'Log',
            'route' => $this->generateUrl('admin_log')
          ),
        )
      ),
      array(
        'name' => 'Shop',
        'route' => $this->generateUrl('shop'),
        'items' => array(
          array(
            'name' => 'Product',
            'route' => $this->generateUrl('admin_shop_product')
          ),
          array(
            'name' => 'Category',
            'route' => $this->generateUrl('admin_shop_category')
          ),
          array(
            'name' => 'Order',
            'route' => $this->generateUrl('admin_shop_order')
          ),
          array(
            'name' => 'Payment Method',
            'route' => $this->generateUrl('admin_shop_payment_method')
          ),
          array(
            'name' => 'Shipping',
            'route' => $this->generateUrl('admin_shop_shipping')
          ),
        )
      ),
      array(
        'name' => 'Event',
        'route' => $this->generateUrl('admin_event_event'),
        'items' => array()
      ),
      array(
        'name' => 'Account',
        'route' => $this->generateUrl('club_account_adminaccount_index'),
        'items' => array()
      )
    );

    return $this->render('ClubMenuBundle:Default:leftMenu.html.twig', array(
      'menu' => $menu
    ));
  }
}
