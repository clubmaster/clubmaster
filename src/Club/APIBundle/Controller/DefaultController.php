<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  protected function validateKey()
  {
    if ($this->container->getParameter('club_api.api_key') != $this->getRequest()->headers->get('API_KEY'))
      return false;

    return true;
  }
}
