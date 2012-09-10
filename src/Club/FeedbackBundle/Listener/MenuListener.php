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

  public function onTopRightMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = array(
      'name' => $this->translator->trans('Feedback'),
      'route' => $this->router->generate('club_feedback_feedback_index')
    );

    $event->appendItem($menu);
  }
}
