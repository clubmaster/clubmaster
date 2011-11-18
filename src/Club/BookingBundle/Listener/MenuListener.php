<?php

namespace Club\BookingBundle\Listener;

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
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu[] = array(
      'name' => $this->translator->trans('Booking'),
      'route' => $this->router->generate('club_booking_booking_index')
    );

    $event->setMenu($menu);
  }
}
