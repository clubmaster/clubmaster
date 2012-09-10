<?php

namespace Club\BookingBundle\Listener;

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
        if ($this->security_context->isGranted('ROLE_TEAM_ADMIN')) {

            $menu[45] = array(
                'header' => $this->translator->trans('Booking'),
                'image' => 'bundles/clublayout/images/icons/16x16/time.png',
                'items' => array(
                    array(
                        'name' => $this->translator->trans('Booking plans'),
                        'route' => $this->router->generate('club_booking_adminplan_index')
                    ),
                    array(
                        'name' => $this->translator->trans('Fields administration'),
                        'route' => $this->router->generate('club_booking_adminfield_index'),
                    )
                )
            );

            $event->appendMenu($menu);
        }
    }

    public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu[35] = array(
            'name' => $this->translator->trans('Booking'),
            'route' => $this->router->generate('club_booking_overview_index')
        );

        $event->appendMenu($menu);
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu = array();

        $menu[35] = array(
            'name' => $this->translator->trans('Booking'),
            'route' => $this->router->generate('club_booking_overview_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/time.png',
            'text' => 'Velkommen til booking siden, her kan du finde og reservere dine kommende tider.'
        );

        $event->appendMenu($menu);
    }
}
