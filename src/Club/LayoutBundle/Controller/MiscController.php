<?php

namespace Club\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
  public function logoAction()
  {
    try {
      $logo_url = $this->container->getParameter('club_layout.logo_url');
      $url = $this->get('router')->generate($logo_url);
    } catch (\Symfony\Component\Routing\Exception\RouteNotFoundException $e) {

      try {
        $r = $this->get('router')->match($logo_url);
        $url = $this->get('router')->generate($r['_route']);
      } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
      }
    }

    if (!isset($url)) {
      if (preg_match("/^http:\/\//", $logo_url)) {
        $url = $logo_url;
      } else {
        $url = 'http://'.$logo_url;
      }
    }

    return $this->render('ClubLayoutBundle:Misc:logo.html.twig', array(
      'logo_path' => $this->container->getParameter('club_layout.logo_path'),
      'logo_url' => $url,
      'logo_title' => $this->container->getParameter('club_layout.logo_title'),
    ));
  }
}
