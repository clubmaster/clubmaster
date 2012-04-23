<?php

namespace Club\FeedbackBundle\Listener;

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
    $menu = $event->getMenuRight();
    $menu[] = array(
      'name' => $this->translator->trans('Feedback'),
      'route' => $this->router->generate('club_feedback_feedback_index')
    );

    $event->appendItemRight($menu);
  }
}
