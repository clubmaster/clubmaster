<?php

namespace Club\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
    $em = $this->getDoctrine()->getEntityManager();

    $user = new \Club\UserBundle\Entity\User();
    $user->setMemberNumber($em->getRepository('Club\UserBundle\Entity\User')->findNextMemberNumber());
    $user->setPassword(1234);
    $em->persist($user);
    $em->flush();

    $profile = new \Club\UserBundle\Entity\Profile();
    $profile->setUser($user);
    $profile->setFirstName($this->getRequest()->get('first_name'));
    $profile->setLastName($this->getRequest()->get('last_name'));
    $profile->setGender($this->getRequest()->get('gender'));
    $profile->setDayOfBirth(new \DateTime($this->getRequest()->get('day_of_birth')));
    $em->persist($profile);

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $address->setProfile($profile);
    $address->setContactType('home');
    $address->setIsDefault(1);
    $address->setStreet($this->getRequest()->get('street'));
    $address->setPostalCode($this->getRequest()->get('postal_code'));
    $address->setCity($this->getRequest()->get('city'));
    $country = $em->getRepository('\Club\UserBundle\Entity\Country')->findOneByCountry($this->getRequest()->get('country'));
    $address->setCountry($country);

    $em->persist($address);

    $user->setProfile($profile);
    $em->persist($user);

    $em->flush();

    return ($r = $this->hasErrors($user)) ? $r : $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/get/user/{id}")
   */
  public function getUserAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/delete/user/{id}")
   * @Method("DELETE")
   */
  public function deleteUserAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    $em->remove($user);
    $em->flush();

    return $this->renderJSon();
  }

  /**
   * @Route("/get/users")
   */
  public function getUsersAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $users = $em->getRepository('Club\UserBundle\Entity\User')->findAll();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    return $this->renderJSon($res);
  }

  /**
   * @Route("/get/users/active")
   */
  public function getUsersActiveAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $users = $em->getRepository('Club\UserBundle\Entity\User')->findAllActive();

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
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    $ban = new \Club\UserBundle\Entity\Ban();
    $ban->setUser($user);
    $ban->setType('user');
    $ban->setValue($user->getId());

    $em->persist($ban);
    $em->flush();

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/add/user_role")
   */
  public function addUserRole()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $em->find('Club\UserBundle\Entity\User',$this->getRequest()->get('user'));
    $role = $em->find('Club\UserBundle\Entity\Role',$this->getRequest()->get('role'));

    $user->addRole($role);

    $em->persist($user);
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
