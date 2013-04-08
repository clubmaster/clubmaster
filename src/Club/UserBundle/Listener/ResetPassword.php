<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ResetPassword
{
    protected $router;
    protected $security;
    protected $em;
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->security = $container->get('security.context');
        $this->router = $container->get('router');
    }

    public function onKernelRequest($event)
    {
        switch (true) {
        case $this->container->get('club_installer.installer')->installerOpen():
        case HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType():
        case preg_match("/user\/reset$/", $this->container->get('request')->getURI()):
            return;
        }

        if ($this->security->getToken() && $this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $reset = $this->em->getRepository('ClubUserBundle:ResetPassword')->getByUser($this->security->getToken()->getUser());

            if ($reset) {
                $response = new RedirectResponse($this->router->generate('club_user_user_reset'));
                $event->setResponse($response);
            }
        }
    }
}
