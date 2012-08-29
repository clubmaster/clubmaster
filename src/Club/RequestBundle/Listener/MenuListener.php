<?php

namespace Club\RequestBundle\Listener;

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
        $menu[] = array(
            'name' => $this->translator->trans('Players market'),
            'route' => $this->router->generate('club_request_playermarket_index')
        );

        $event->appendItem($menu);
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu = array();

        $menu[17] = array(
            'name' => $this->translator->trans('Market'),
            'route' => $this->router->generate('club_request_playermarket_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/connect.png',
            'text' => 'Gå på opdagelse i spiller markedet, har kan du finde andre spillere som leder efter en makker som gerne vil ned at spille.'
        );

        $event->appendItemDash($menu);
    }
}
