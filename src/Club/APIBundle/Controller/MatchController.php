<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/matches")
 */
class MatchController extends Controller
{
  /**
   * @Route("/search/{id}/{query}")
   * @Method("GET")
   */
  public function searchAction($id, $query)
  {
    $em = $this->getDoctrine()->getManager();
    $league = $em->find('ClubMatchBundle:League', $id);

    $res = array();
    if (!$league->getInviteOnly()) {

      $search = array('query' => $query);
      if ($league->getGender()) $search['gender'] = $league->getGender();

      $users = $em->getRepository('ClubUserBundle:User')->getBySearch($search);
      foreach ($users as $user) {
        $res[] = $user->toArray('simple');
      }

    } else {
      $league = $em->getRepository('ClubMatchBundle:League')->getUsersBySearch($league, $query);
      if ($league) {
        foreach ($league->getUsers() as $user) {
          $res[] = $user->toArray('simple');
        }
      }
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
