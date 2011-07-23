<?php

namespace Club\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
  public function topMenuAction()
  {
    $menu = array(
      array(
        'name' => 'User',
        'route' => $this->generateUrl('user')
      ),
      array(
        'name' => 'Shop',
        'route' => $this->generateUrl('shop')
      ),
      array(
        'name' => 'Order',
        'route' => $this->generateUrl('shop_order')
      ),
      array(
        'name' => 'Subscription',
        'route' => $this->generateUrl('shop_subscription')
      ),
      array(
        'name' => 'Event',
        'route' => $this->generateUrl('event_event')
      )
    );

    return $this->render('ClubMenuBundle:Default:topMenu.html.twig', array(
      'menu' => $menu
    ));
  }

  public function leftMenuAction()
  {
    $menu = array();

    if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
      $menu = array(
        'user' => array(
          'name' => 'User',
          'route' => $this->generateUrl('admin_user'),
        ),
        'location' => array(
          'name' => 'Location',
          'route' => $this->generateUrl('admin_location')
        ),
        'group' => array(
          'name' => 'Group',
          'route' => $this->generateUrl('admin_group')
        ),
        'currency' => array(
          'name' => 'Currency',
          'route' => $this->generateUrl('admin_currency')
        ),
        'ban' => array(
          'name' => 'Ban',
          'route' => $this->generateUrl('ban')
        ),
        'task' => array(
          'name' => 'Task',
          'route' => $this->generateUrl('admin_task')
        ),
        'log' => array(
          'name' => 'Log',
          'route' => $this->generateUrl('admin_log')
        ),
        'mail' => array(
          'name' => 'Mail',
          'route' => $this->generateUrl('club_mail_adminmail_index')
        ),
        'shop' => array(
          'name' => 'Shop',
          'route' => $this->generateUrl('admin_shop_product'),
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
              'name' => 'Coupon',
              'route' => $this->generateUrl('club_shop_admincoupon_index')
            ),
            array(
              'name' => 'Special',
              'route' => $this->generateUrl('club_shop_adminspecial_index')
            ),
            array(
              'name' => 'Payment Method',
              'route' => $this->generateUrl('admin_shop_payment_method')
            ),
            array(
              'name' => 'Shipping',
              'route' => $this->generateUrl('admin_shop_shipping')
            ),
          ),
        ),
      );
    }

    $event = new \Club\MenuBundle\Event\FilterMenuEvent($menu);
    $this->get('event_dispatcher')->dispatch(\Club\MenuBundle\Event\Events::onLeftMenuRender, $event);
    $menu = $event->getMenu();

    if (preg_match("/admin\/([^\/]+)?.*$/", $this->getRequest()->getRequestUri(),$rtn)) {
      if (isset($menu[$rtn[1]])) {
        $menu[$rtn[1]]['active'] = 1;
      }
    }

    return $this->render('ClubMenuBundle:Default:leftMenu.html.twig', array(
      'menu' => $menu
    ));
  }
}
