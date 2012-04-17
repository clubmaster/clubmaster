<?php

namespace Club\MatchBundle\Listener;

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
    $menu[100] = array(
      'name' => $this->translator->trans('League'),
      'route' => $this->router->generate('club_match_league_index')
    );

    $event->appendItem($menu);
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if ($this->security_context->isGranted('ROLE_MATCH_ADMIN')) {
      $menu[75] = array(
        'name' => $this->translator->trans('League'),
        'route' => $this->router->generate('club_match_adminleague_index'),
        'items' => array(
          array(
            'name' => $this->translator->trans('Rule'),
            'route' => $this->router->generate('club_match_adminrule_index')
          )
        )
      );
    }

    $event->appendItem($menu);
  }
}
