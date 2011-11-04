<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
  /**
   * @Route("/")
   * @Method("GET")
   */
  public function indexAction()
  {
    if (!$this->validateKey())
      return new Response('Wrong API key', 403);

    $em = $this->getDoctrine()->getEntityManager();
    $users = $em->getRepository('ClubUserBundle:User')->findAll();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    return new Response($this->get('club_api.encode')->encode($res));
  }

  /**
   * @Route("/{id}")
   * @Method("GET")
   */
  public function getAction($id)
  {
    if (!$this->validateKey())
      return new Response('Wrong API key', 403);

    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User', $id);

    return new Response($this->get('club_api.encode')->encode($user->toArray()));
  }
}
