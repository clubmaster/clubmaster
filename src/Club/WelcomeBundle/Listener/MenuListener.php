<?php

namespace Club\WelcomeBundle\Listener;

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
    $menu = $event->getMenu();

    if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
      $menu[] = array(
        'name' => $this->translator->trans('Login'),
        'route' => $this->router->generate('login')
      );
    }

    $event->setMenu($menu);
  }
}
