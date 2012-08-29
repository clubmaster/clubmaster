<?php

namespace Club\EventBundle\Listener;

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

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu[150] = array(
      'name' => $this->translator->trans('Event'),
      'route' => $this->router->generate('event_event')
    );

    $event->appendItem($menu);
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if ($this->security_context->isGranted('ROLE_EVENT_ADMIN')) {
      $menu[55] = array(
        'name' => $this->translator->trans('Event'),
        'route' => $this->router->generate('admin_event_event'),
        'items' => array()
      );

      $event->appendItem($menu);
    }
  }

  public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
      $menu = array();

      $menu[] = array(
          'name' => $this->translator->trans('Events'),
          'route' => $this->router->generate('club_request_playermarket_index'),
          'image' => 'bundles/clublayout/images/icons/32x32/calendar.png',
          'text' => 'Hvad sker der i klubben, er der nogen grill arrangementer, er der nogen turneringer klik her og følg med.'
      );

      $event->appendItemDash($menu);
  }
}
