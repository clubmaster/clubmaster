<?php

namespace Club\UserBundle\Listener;

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
    $menu[9] = array(
      'name' => $this->translator->trans('Admin Dashboard'),
      'route' => $this->router->generate('club_dashboard_admindashboard_index'),
    );
    $menu[10] = array(
      'name' => $this->translator->trans('Members'),
      'route' => $this->router->generate('admin_user'),
    );
    $menu[12] = array(
      'name' => $this->translator->trans('Group'),
      'route' => $this->router->generate('admin_group')
    );
    $menu[14] = array(
      'name' => $this->translator->trans('Location'),
      'route' => $this->router->generate('admin_location')
    );
    $menu[16] = array(
      'name' => $this->translator->trans('Administration'),
      'route' => $this->router->generate('ban'),
      'items' => array(
        array(
          'name' => $this->translator->trans('Ban'),
          'route' => $this->router->generate('ban')
        ),
        array(
          'name' => $this->translator->trans('Task'),
          'route' => $this->router->generate('admin_task')
        ),
        array(
          'name' => $this->translator->trans('Log'),
          'route' => $this->router->generate('club_log_log_index')
        ),
        array(
          'name' => $this->translator->trans('Currency'),
          'route' => $this->router->generate('admin_currency')
        ),
      )
    );

    $event->appendItem($menu);
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
      $menu[15] = array(
        'name' => $this->translator->trans('My profile'),
        'route' => $this->router->generate('user')
      );
    }

    $menu[20] = array(
      'name' => $this->translator->trans('Members'),
      'route' => $this->router->generate('club_user_member_index')
    );

    $event->appendItem($menu);
  }
}
