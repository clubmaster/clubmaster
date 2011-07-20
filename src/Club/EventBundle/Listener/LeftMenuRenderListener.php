<?php

namespace Club\EventBundle\Listener;

class LeftMenuRenderListener
{
  private $router;
  private $security_context;

  public function __construct($router, $security_context)
  {
    $this->router = $router;
    $this->security_context = $security_context;
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    if ($this->security_context->isGranted('ROLE_EVENT_ADMIN')) {
      $menu[] = array(
        'name' => 'Event',
        'route' => $this->router->generate('admin_event_event'),
        'items' => array()
      );
    }

    $event->setMenu($menu);
  }
}
