<?php

namespace Club\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  /**
   * @Route("/add/user")
   * @Method("POST")
   */
  public function addUserAction()
  {
    return $this->renderJSon();
  }

  /**
   * @Route("/get/user/{id}")
   */
  public function getUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    return $this->renderJSon($user);
  }

  /**
   * @Route("/delete/user/{id}")
   * @Method("DELETE")
   */
  public function deleteUserAction()
  {
    return $this->renderJSon();
  }

  /**
   * @Route("/get/user")
   */
  public function getUsersAction()
  {
    return $this->renderJSon();
  }

  private function renderJSon($array=array(),$status_code="200")
  {
    $response = new Response(json_encode($array));
    $response->setStatusCode($status_code);
    $response->headers->set('Content-Type','application/json');

    return $response;
  }

}
