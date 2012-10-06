<?php

namespace Club\ExchangeBundle\Listener;

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
        $menu[22] = array(
            'name' => $this->translator->trans('Exchange'),
            'route' => $this->router->generate('club_exchange_exchange_index')
        );

        $event->appendMenu($menu);
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu = array();

        $menu[17] = array(
            'name' => $this->translator->trans('Exchange'),
            'route' => $this->router->generate('club_exchange_exchange_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/connect.png',
            'text' => $this->translator->trans('Take a look in the exchange market, you can find other players that need a partner.')
        );

        $event->appendMenu($menu);
    }
}
