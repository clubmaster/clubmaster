<?php

namespace Club\PasskeyBundle\Listener;

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
    if ($this->security_context->isGranted('ROLE_PASSKEY_ADMIN')) {
      $menu[64] = array(
        'name' => $this->translator->trans('Passkey'),
        'route' => $this->router->generate('club_passkey_adminpasskey_index')
      );
      $event->appendItem($menu);
    }
  }
}
