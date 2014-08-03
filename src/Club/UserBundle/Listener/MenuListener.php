<?php

namespace Club\UserBundle\Listener;

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

            $menu[9] = array(
                'name' => $this->translator->trans('Admin Dashboard'),
                'route' => $this->router->generate('club_dashboard_admindashboard_index')
            );
            $menu[10] = array(
                'header' => 'General',
                'image' => 'bundles/clublayout/images/icons/16x16/house.png',
                'items' => array(
                    array(
                        'name' => $this->translator->trans('Users'),
                        'route' => $this->router->generate('admin_user')
                    ),
                    array(
                        'name' => $this->translator->trans('Group'),
                        'route' => $this->router->generate('admin_group')
                    ),
                    array(
                        'name' => $this->translator->trans('Location'),
                        'route' => $this->router->generate('admin_location')
                    ),
                    array(
                        'name' => $this->translator->trans('Currency'),
                        'route' => $this->router->generate('admin_currency')
                    )
                )
            );

            $menu[16] = array(
                'header' => $this->translator->trans('Administration'),
                'image' => 'bundles/clublayout/images/icons/16x16/wrench.png',
                'items' => array(
                    array(
                        'name' => $this->translator->trans('Task'),
                        'route' => $this->router->generate('admin_task')
                    ),
                    array(
                        'name' => $this->translator->trans('Log'),
                        'route' => $this->router->generate('club_log_log_index')
                    )
                )
            );

            $event->appendMenu($menu);
        }
    }

    public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        if ($this->security_context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu[4] = array(
                'name' => $this->translator->trans('Members'),
                'route' => $this->router->generate('club_user_member_index')
            );

            $event->appendMenu($menu);
        }
    }

    public function onDashMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
    {
        if (!$this->security_context->isGranted('IS_AUTHENTICATED_REMEMBERED')) return;

        $menu = array();

        $menu[11] = array(
            'name' => $this->translator->trans('Members'),
            'route' => $this->router->generate('club_user_member_index'),
            'image' => 'bundles/clublayout/images/icons/32x32/group.png',
            'text' => $this->translator->trans('Here is a list of all members, if you have to contact a specific player, click here.')
        );

        $event->appendMenu($menu);
    }
}
