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
}
