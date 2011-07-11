<?php

namespace Club\AccountBundle\Listener;

class LeftMenuRenderListener
{
  private $router;

  public function __construct($router)
  {
    $this->router = $router;
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu[] = array(
      'name' => 'Account',
      'route' => $this->router->generate('club_account_adminaccount_index'),
      'items' => array()
    );

    $event->setMenu($menu);
  }
}
