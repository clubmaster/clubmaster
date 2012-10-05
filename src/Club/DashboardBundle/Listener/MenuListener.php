<?php

namespace Club\DashboardBundle\Listener;

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
    if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
      $menu[0] = array(
        'header' => $this->translator->trans('Dashboard'),
        'route' => $this->router->generate('club_dashboard_dashboard_index'),
        'items' => array(
            array(
                'name' => $this->translator->trans('Dashboard'),
                'route' => $this->router->generate('club_dashboard_dashboard_index')
            ),
            array(
                'name' => $this->translator->trans('Blog'),
                'route' => $this->router->generate('club_welcome_blog_index')
            )
        )
      );
      $event->appendMenu($menu);
    }
  }
}
