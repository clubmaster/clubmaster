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

    public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        if ($this->security_context->isGranted('ROLE_TEAM_ADMIN')) {
            $menu[29] = array(
                'header' => 'CMS',
                'image' => 'bundles/clublayout/images/icons/16x16/layout.png',
                'items' => array(
                    array(
                        'name' => $this->translator->trans('Frontpage'),
                        'route' => $this->router->generate('club_welcome_adminwelcome_index')
                    ),
                    array(
                        'name' => $this->translator->trans('Blog'),
                        'route' => $this->router->generate('club_welcome_adminblog_index')
                    )
                )
            );

            $event->appendMenu($menu);
        }
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        $menu = array();
        $menu[44] = array(
            'name' => $this->translator->trans('Blog'),
            'route' => $this->router->generate('club_welcome_blog_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/transmit.png',
            'text' => $this->translator->trans('Do you have any news that could interest all the other members in the club, feel free to share here.')
        );

        $event->appendMenu($menu);
    }
}
