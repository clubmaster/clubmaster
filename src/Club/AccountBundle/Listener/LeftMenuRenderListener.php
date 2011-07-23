<?php

namespace Club\AccountBundle\Listener;

class LeftMenuRenderListener
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
    $menu = $event->getMenu();

    if ($this->security_context->isGranted('ROLE_ADMIN')) {
      $menu['account'] = array(
        'name' => $this->translator->trans('Account'),
        'route' => $this->router->generate('club_account_adminaccount_index'),
        'items' => array()
      );
    }

    $event->setMenu($menu);
  }
}
