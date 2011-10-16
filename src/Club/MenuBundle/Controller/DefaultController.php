<?php

namespace Club\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
  public function topMenuAction()
  {
    $menu = array(
      array(
        'name' => $this->get('translator')->trans('Dashboard'),
        'route' => $this->generateUrl('homepage')
      ),
      array(
        'name' => $this->get('translator')->trans('User'),
        'route' => $this->generateUrl('user')
      ),
      array(
        'name' => $this->get('translator')->trans('Shop'),
        'route' => $this->generateUrl('shop')
      ),
      array(
        'name' => $this->get('translator')->trans('Order'),
        'route' => $this->generateUrl('shop_order')
      ),
      array(
        'name' => $this->get('translator')->trans('Subscription'),
        'route' => $this->generateUrl('shop_subscription')
      ),
      array(
        'name' => $this->get('translator')->trans('Event'),
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
          'name' => $this->get('translator')->trans('User'),
          'route' => $this->generateUrl('admin_user'),
        ),
        'group' => array(
          'name' => $this->get('translator')->trans('Group'),
          'route' => $this->generateUrl('admin_group')
        ),
        'location' => array(
          'name' => $this->get('translator')->trans('Location'),
          'route' => $this->generateUrl('admin_location')
        ),
        'shop' => array(
          'name' => $this->get('translator')->trans('Shop'),
          'route' => $this->generateUrl('admin_shop_product'),
          'items' => array(
            array(
              'name' => $this->get('translator')->trans('Product'),
              'route' => $this->generateUrl('admin_shop_product')
            ),
            array(
              'name' => $this->get('translator')->trans('Category'),
              'route' => $this->generateUrl('admin_shop_category')
            ),
            array(
              'name' => $this->get('translator')->trans('Order'),
              'route' => $this->generateUrl('admin_shop_order')
            ),
            array(
              'name' => $this->get('translator')->trans('Coupon'),
              'route' => $this->generateUrl('club_shop_admincoupon_index')
            ),
            array(
              'name' => $this->get('translator')->trans('Special Price'),
              'route' => $this->generateUrl('club_shop_adminspecial_index')
            ),
            array(
              'name' => $this->get('translator')->trans('Payment Method'),
              'route' => $this->generateUrl('admin_shop_payment_method')
            ),
            array(
              'name' => $this->get('translator')->trans('Shipping'),
              'route' => $this->generateUrl('admin_shop_shipping')
            ),
            array(
              'name' => $this->get('translator')->trans('Vat'),
              'route' => $this->generateUrl('club_shop_adminvat_index')
            ),
          ),
        ),
        'admin' => array(
          'name' => $this->get('translator')->trans('Administration'),
          'route' => $this->generateUrl('ban'),
          'items' => array(
            array(
              'name' => $this->get('translator')->trans('Ban'),
              'route' => $this->generateUrl('ban')
            ),
            array(
              'name' => $this->get('translator')->trans('Task'),
              'route' => $this->generateUrl('admin_task')
            ),
            array(
              'name' => $this->get('translator')->trans('Log'),
              'route' => $this->generateUrl('club_log_log_index')
            ),
            array(
              'name' => $this->get('translator')->trans('Currency'),
              'route' => $this->generateUrl('admin_currency')
            ),
            array(
              'name' => $this->get('translator')->trans('Mail Templates'),
              'route' => $this->generateUrl('club_mail_adminmail_index')
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
