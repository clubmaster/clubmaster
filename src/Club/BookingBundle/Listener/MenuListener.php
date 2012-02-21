<?php

namespace Club\BookingBundle\Listener;

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

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if (!$this->enabled) return;

    $menu = $event->getMenu();

    $menu[] = array(
      'name' => $this->translator->trans('Booking'),
      'route' => $this->router->generate('club_booking_adminfield_index'),
      'items' => array(
        array(
          'name' => $this->translator->trans('Field'),
          'route' => $this->router->generate('club_booking_adminfield_index')
        ),
        array(
          'name' => $this->translator->trans('Plan category'),
          'route' => $this->router->generate('club_booking_adminplancategory_index')
        ),
      )
    );

    $event->setMenu($menu);

  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if (!$this->enabled) return;

    $menu = $event->getMenu();

    $menu[] = array(
      'name' => $this->translator->trans('Booking'),
      'route' => $this->router->generate('club_booking_overview_index')
    );

    $event->setMenu($menu);
  }
}
