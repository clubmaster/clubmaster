<?php

namespace Club\EventBundle\Listener;

class LeftMenuRenderListener
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

    if ($this->security_context->isGranted('ROLE_EVENT_ADMIN')) {
      $menu['event'] = array(
        'name' => $this->translator->trans('Event'),
        'route' => $this->router->generate('admin_event_event'),
        'items' => array()
      );
    }

    $event->setMenu($menu);
  }
}
