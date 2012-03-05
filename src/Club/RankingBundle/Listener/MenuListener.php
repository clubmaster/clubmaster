<?php

namespace Club\RankingBundle\Listener;

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

    $menu[100] = array(
      'name' => $this->translator->trans('Ranking'),
      'route' => $this->router->generate('club_ranking_game_index')
    );

    $event->setMenu($menu);
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if (!$this->enabled) return;
    $menu = $event->getMenu();

    if ($this->security_context->isGranted('ROLE_RANKING_ADMIN')) {
      $menu[75] = array(
        'name' => $this->translator->trans('Ranking'),
        'route' => $this->router->generate('club_ranking_admingame_index'),
        'items' => array(
          array(
            'name' => $this->translator->trans('Rule'),
            'route' => $this->router->generate('club_ranking_adminrule_index')
          )
        )
      );
    }

    $event->setMenu($menu);
  }
}
