<?php

namespace Club\TeamBundle\Listener;

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
          $menu[65] = array(
              'header' => $this->translator->trans('Team'),
              'items' => array(
                  array(
                      'name' => $this->translator->trans('Team'),
                      'route' => $this->router->generate('club_team_adminteamcategory_index'),
                  ),
                  array(
                      'name' => $this->translator->trans('Level'),
                      'route' => $this->router->generate('club_team_adminlevel_index')
                  )
              )
          );
          $event->appendMenu($menu);
      }
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu[55] = array(
      'name' => $this->translator->trans('Team'),
      'route' => $this->router->generate('club_team_team_index')
    );

    $event->appendMenu($menu);
  }

  public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
      $menu = array();

      $menu[15] = array(
          'name' => $this->translator->trans('Team'),
          'route' => $this->router->generate('club_team_team_index'),
          'image' => 'bundles/clublayout/images/icons/32x32/book.png',
          'text' => 'Her kan du finde alle vores hold, gå på opdagelse og se hvad vi tilbyder.'
      );

      $event->appendMenu($menu);
  }
}
