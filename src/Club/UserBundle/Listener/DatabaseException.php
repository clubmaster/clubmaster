<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DatabaseException
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $class = get_class($exception);
        if (preg_match('/(Doctrine\\\\DBAL\\\\DBALException|PDOException)/', $class)) {
            if (preg_match("/(Unknown database|Base table or view not found)/", $exception->getMessage())) {

                $path = 'web/setup.php';
                $not_found = true;

                for ($i = 0; $not_found; $i++) {
                    if (is_file($path)) {
                        $response = new RedirectResponse('../'.$path);
                        $not_found = false;
                    } else {
                        $path = '../'.$path;
                    }

                    if ($i > 5) break;
                }

                if (!isset($response)) {
                    $response = new Response('Please visit the setup.php page.');
                }

                $event->setResponse($response);
            }
        }
    }
}
