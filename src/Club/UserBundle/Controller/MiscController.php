<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class MiscController extends Controller
{
  public function getUsernameAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    return new Response($user->getProfile()->getName());
  }

  public function getCurrentLocationAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('\Club\UserBundle\Entity\Location',$this->get('session')->get('location_id'));

    return new Response($location->getLocationName());
  }
}
