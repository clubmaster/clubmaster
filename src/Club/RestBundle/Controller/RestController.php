<?php

namespace Club\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RestController extends Controller
{
  /**
   * @Route("/get/user/{id}")
   */
  public function getUserAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/get/users")
   */
  public function getUsersAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $users = $em->getRepository('ClubUserBundle:User')->findAll();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    return $this->renderJSon($res);
  }

  /**
   * @Route("/ban/user/{id}")
   */
  public function banUserAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $ban = new \Club\UserBundle\Entity\Ban();
    $ban->setUser($user);
    $ban->setType('user');
    $ban->setValue($user->getId());

    $em->persist($ban);
    $em->flush();

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/add/event")
   */
  public function addEventAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $event = new \Club\EventBundle\Entity\Event();
    $event->setEventName($this->getRequest()->get('event_name'));
    $event->setDescription($this->getRequest()->get('description'));
    $event->setStartDate(new \DateTime($this->getRequest()->get('start_date')));
    $event->setStopDate(new \DateTime($this->getRequest()->get('stop_date')));

    $em->persist($event);
    $em->flush();

    return $this->renderJSon($event->toArray());
  }

  protected function hasErrors($object)
  {
    $errors = $this->get('validator')->validate($object);

    if (count($errors) > 0) {
      return $this->renderError($errors);
    }

    return false;
  }

  protected function renderError($errors,$status_code="403")
  {
    $res = array();
    foreach ($errors as $error) {
      $res[] = array(
        'field' => $error->getPropertyPath(),
        'message' => $error->getMessage()
      );
    }

    return $this->renderJSon($res,$status_code);
  }

  protected function renderJSon($array=array(),$status_code="200")
  {
    $response = new Response(json_encode($array));
    $response->setStatusCode($status_code);
    $response->headers->set('Content-Type','application/json');

    return $response;
  }
}
