<?php

namespace Club\EventBundle\Listener;

class MenuListener
{
  private $router;
  private $security_context;
  private $translator;
  private $enabled;

  public function __construct($router, $security_context, $translator, $enabled)
  {
    $this->router = $router;
    $this->security_context = $security_context;
    $this->translator = $translator;
    $this->enabled = $enabled;
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if (!$this->enabled) return;

    $menu = $event->getMenu();

    $menu[150] = array(
      'name' => $this->translator->trans('Event'),
      'route' => $this->router->generate('event_event')
    );

    $event->setMenu($menu);
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if (!$this->enabled) return;
    $menu = $event->getMenu();

    if ($this->security_context->isGranted('ROLE_EVENT_ADMIN')) {
      $menu[55] = array(
        'name' => $this->translator->trans('Event'),
        'route' => $this->router->generate('admin_event_event'),
        'items' => array()
      );
    }

    $event->setMenu($menu);
  }
}
