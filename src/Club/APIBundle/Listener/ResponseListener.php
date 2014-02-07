<?php

namespace Club\APIBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$this->request->getCurrentRequest()) {
            return;
        }

        if (!preg_match("/^\/api/", $this->request->getCurrentRequest()->getPathInfo())) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('WWW-Authenticate', null);
        $event->setResponse($response);
    }
}
