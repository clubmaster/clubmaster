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
      $res[] = array(
        'id' => $user->getId(),
        'member_number' => $user->getMemberNumber(),
        'first_name' => $user->getProfile()->getFirstName(),
        'last_name' => $user->getProfile()->getLastName(),
        'gender' => $user->getProfile()->getGender(),
        'day_of_birth' => $user->getProfile()->getDayOfBirth(),
        'created_at' => $user->getCreatedAt(),
        'updated_at' => $user->getUpdatedAt()
      );
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

    $res = array(
      'id' => $user->getId(),
      'member_number' => $user->getMemberNumber(),
      'first_name' => $user->getProfile()->getFirstName(),
      'last_name' => $user->getProfile()->getLastName(),
      'gender' => $user->getProfile()->getGender(),
      'day_of_birth' => $user->getProfile()->getDayOfBirth(),
      'created_at' => $user->getCreatedAt(),
      'updated_at' => $user->getUpdatedAt(),
      'member_status' => $user->getMemberStatus()
    );

    if ($user->getProfile()->getProfileAddress()) {
      $res['street'] = $user->getProfile()->getProfileAddress()->getStreet();
      $res['postal_code'] = $user->getProfile()->getProfileAddress()->getPostalCode();
      $res['city'] = $user->getProfile()->getProfileAddress()->getCity();
      $res['state'] = $user->getProfile()->getProfileAddress()->getState();
      $res['country'] = $user->getProfile()->getProfileAddress()->getCountry()->getCountry();
    }

    if ($user->getProfile()->getProfilePhone()) {
      $res['phone_number'] = $user->getProfile()->getProfilePhone()->getPhoneNumber();
    }

    if ($user->getProfile()->getProfileEmail()) {
      $res['email_address'] = $user->getProfile()->getProfileEmail()->getEmailAddress();
    }

    $res['subscriptions'] = array();
    foreach ($user->getSubscriptions() as $sub) {
      $res['subscriptions'][] = array(
        'id' => $sub->getId(),
        'type' => $sub->getType(),
        'start_date' => $sub->getStartDate(),
        'expire_date' => $sub->getExpireDate()
      );
    }

    $res['groups'] = array();
    foreach ($user->getGroups() as $group) {
      $res['groups'][] = array(
        'id' => $group->getId(),
        'group_name' => $group->getGroupName()
      );
    }

    return new Response($this->get('club_api.encode')->encode($res));
  }
}
