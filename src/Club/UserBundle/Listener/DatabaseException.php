<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DatabaseException
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

    public function onKernelException($event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $exception = $event->getException();

        if (get_class($exception) == 'PDOException' && preg_match("/Unknown database/", $exception->getMessage())) {
                $response = new RedirectResponse($this->router->generate('club_installer_installer_index'));
                $event->setResponse($response);
        }
    }
}
