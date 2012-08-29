<?php

namespace Club\TournamentBundle\Listener;

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
    if ($this->security_context->isGranted('ROLE_TOURNAMENT_ADMIN')) {
      $menu[42] = array(
        'name' => $this->translator->trans('Tournament'),
        'route' => $this->router->generate('club_tournament_admintournament_index')
      );
      $event->appendItem($menu);
    }
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu[55] = array(
      'name' => $this->translator->trans('Team'),
      'route' => $this->router->generate('club_team_team_index')
    );

    $event->appendItem($menu);
  }
}
