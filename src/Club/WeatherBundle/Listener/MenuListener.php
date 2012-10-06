<?php

namespace Club\WeatherBundle\Listener;

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

  public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
      $menu = array();

      $menu[33] = array(
          'name' => $this->translator->trans('Weather'),
          'route' => $this->router->generate('club_weather_weather_index'),
          'image' => 'bundles/clublayout/images/icons/32x32/weather_sun.png',
          'text' => $this->translator->trans('If you need to check out the weather forecast to find the best time to play, click here.')
      );

      $event->appendMenu($menu);
  }
}
