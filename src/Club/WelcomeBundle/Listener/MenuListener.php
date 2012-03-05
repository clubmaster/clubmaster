<?php

namespace Club\WelcomeBundle\Listener;

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

    $menu[29] = array(
      'name' => $this->translator->trans('Blog'),
      'route' => $this->router->generate('club_welcome_adminblog_index'),
      'items' => array()
    );

    $event->setMenu($menu);
  }
}
