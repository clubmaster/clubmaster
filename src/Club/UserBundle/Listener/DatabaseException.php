<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class DatabaseException
{
    private $container;
    private $router;

    public function __construct($container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
            $exception = $event->getException();
            if (preg_match('/Doctrine\\\\DBAL\\\\DBALException/', get_class($exception))) {
                $response = new Response('Please visit the setup.php page.');
                $event->setResponse($response);
            }
    }
}
