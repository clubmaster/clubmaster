<?php

namespace Club\MediaBundle\Listener;

use Club\MenuBundle\Event\FilterMenuEvent;

class MenuListener
{
    private $router;
    private $security_context;
    private $translator;
    private $container;

    public function __construct($router, $security_context, $translator, $container)
    {
        $this->router = $router;
        $this->security_context = $security_context;
        $this->translator = $translator;
        $this->container = $container;
    }

    public function onLeftMenuRender(FilterMenuEvent $event)
    {
        if ($this->security_context->isGranted('ROLE_MEDIA_ADMIN')) {

            $menu[24] = array(
                'header' => 'Media',
                'image' => 'bundles/clublayout/images/icons/16x16/ftp.png',
                'items' => array(
                    array(
                        'name' => $this->translator->trans('File basket'),
                        'route' => $this->router->generate('admin_media_document')
                    )
                )
            );

            $event->appendMenu($menu);
        }
    }
}
