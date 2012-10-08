<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class DatabaseException
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $class = get_class($exception);
        if (preg_match('/(Doctrine\\\\DBAL\\\\DBALException|PDOException)/', $class)) {
            if (preg_match("/(Unknown database|Base table or view not found)/", $exception->getMessage())) {
                $response = new Response('Please visit the setup.php page.');
                $event->setResponse($response);
            }
        }
    }
}
