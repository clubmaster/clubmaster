<?php

namespace Club\NewsBundle\Listener;

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
      if ($this->security_context->isGranted('ROLE_TOURNAMENT_ADMIN')) {
          $menu = array(
              'header' => $this->translator->trans('Match'),
              'items' => array(
                  array(
                      'name' => $this->translator->trans('Tournament'),
                      'route' => $this->router->generate('club_tournament_admintournament_index')
                  )
              )
          );
          $event->appendItem($menu);
      }
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if ($this->security_context->isGranted('ROLE_NEWS_ADMIN')) {
      $menu[71] = array(
        'name' => $this->translator->trans('News ticker'),
        'route' => $this->router->generate('club_news_adminticker_index')
      );

    $event->appendMenu($menu);
  }
}
