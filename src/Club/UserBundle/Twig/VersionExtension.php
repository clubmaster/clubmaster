<?php

namespace Club\UserBundle\Twig;

class VersionExtension extends \Twig_Extension
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return array(
            'club_version' => $this->container->get('club_user.version')->getVersion()
        );
    }

    public function getName()
    {
        return 'club_version';
    }
}
