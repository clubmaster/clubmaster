<?php

namespace Club\CheckinBundle\Listener;

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
      if ($this->security_context->isGranted('ROLE_TEAM_ADMIN')) {
          $menu = array(
              'header' => $this->translator->trans('Administration'),
              'items' => array(
                  array(
                      'name' => $this->translator->trans('Checkin'),
                      'route' => $this->router->generate('club_checkin_admincheckin_index'),
                  )
              )
          );
          $event->appendItem($menu);
      }
  }
}
