<?php

namespace Club\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function topMenuAction()
    {
        $event = new \Club\MenuBundle\Event\FilterMenuEvent();
        $this->get('event_dispatcher')->dispatch(\Club\MenuBundle\Event\Events::onTopMenuRender, $event);
        $menu = $event->getMenu();
        $menu_right = $event->getMenuRight();

        ksort($menu);
        ksort($menu_right);

        return $this->render('ClubMenuBundle:Default:topMenu.html.twig', array(
            'menu' => $menu,
            'menu_right' => $menu_right
        ));
    }

    public function leftMenuAction()
    {
        $event = new \Club\MenuBundle\Event\FilterMenuEvent();
        $this->get('event_dispatcher')->dispatch(\Club\MenuBundle\Event\Events::onLeftMenuRender, $event);
        $menu = $event->getMenu();

        ksort($menu);
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
