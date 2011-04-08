<?php

namespace Club\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Club\UserBundle\Entity\User;
use Club\UserBundle\Entity\Profile;

class DefaultController extends Controller
{
  /**
   * @Route("/add/user")
   * @Method("POST")
   */
  public function addUserAction()
  {
    $user = new User();

    $em = $this->get('doctrine.orm.entity_manager');
    $em->persist($user);
    $em->flush();

    $profile = new Profile();
    $profile->setUser($user);
    $profile->setFirstName($this->get('request')->get('first_name'));
    $profile->setLastName($this->get('request')->get('last_name'));

    $em->persist($profile);
    $em->flush();

    $user->setProfile($profile);
    $em->persist($user);
    $em->flush();

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/get/user/{id}")
   */
  public function getUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/delete/user/{id}")
   * @Method("DELETE")
   */
  public function deleteUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    $em->remove($user);
    $em->flush();

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
