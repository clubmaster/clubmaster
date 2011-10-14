<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
  /**
   * @Route("")
   */
  public function indexAction()
  {
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
   */
  public function getAction($id)
  {
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

    return new Response($this->get('club_api.encode')->encode($res));
  }

  /**
   * @Route("/{id}/subscription")
   */
  public function subscriptionAction($id)
  {
  }
}
