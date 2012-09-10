<?php

namespace Club\MessageBundle\Listener;

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
      $menu = $event->getMenu();

      if ($this->security_context->isGranted('ROLE_MESSAGE_ADMIN')) {
          $menu[33] = array(
              'header' => $this->translator->trans('Message'),
              'image' => 'bundles/clublayout/images/icons/16x16/email.png',
              'items' => array(
                  array(
                      'name' => $this->translator->trans('Message'),
                      'route' => $this->router->generate('club_message_adminmessage_index'),
                  )
              )
          );
      }

      $event->setMenu($menu);
  }
}
