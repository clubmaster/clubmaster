<?php

namespace Club\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
  public function logoAction()
  {
    return $this->render('ClubLayoutBundle:Misc:logo.html.twig', array(
      'logo_path' => $this->container->getParameter('club_layout.logo_path'),
      'logo_url' => $this->container->getParameter('club_layout.logo_url'),
      'logo_title' => $this->container->getParameter('club_layout.logo_title'),
    ));
  }
}
