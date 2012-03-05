<?php

namespace Club\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
  public function topMenuAction()
  {
    $menu = array();

    $event = new \Club\MenuBundle\Event\FilterMenuEvent($menu);
    $this->get('event_dispatcher')->dispatch(\Club\MenuBundle\Event\Events::onTopMenuRender, $event);
    $menu = $event->getMenu();

    ksort($menu);

    return $this->render('ClubMenuBundle:Default:topMenu.html.twig', array(
      'menu' => $menu
    ));
  }

  public function leftMenuAction()
  {
    $menu = array();

    if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
      $event = new \Club\MenuBundle\Event\FilterMenuEvent($menu);
      $this->get('event_dispatcher')->dispatch(\Club\MenuBundle\Event\Events::onLeftMenuRender, $event);
      $menu = $event->getMenu();

      ksort($menu);
      if (preg_match("/admin\/([^\/]+)?.*$/", $this->getRequest()->getRequestUri(),$rtn)) {
        if (isset($menu[$rtn[1]])) {
          $menu[$rtn[1]]['active'] = 1;
        }
      }
    }

    return $this->render('ClubMenuBundle:Default:leftMenu.html.twig', array(
      'menu' => $menu
    ));
  }
}
