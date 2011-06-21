<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MiscController extends Controller
{
  public function getUsernameAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    return new Response($user->getProfile()->getName());
  }

  public function getCurrentLocationAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('\Club\UserBundle\Entity\Location',$this->get('session')->get('location_id'));

    return new Response($location->getLocationName());
  }

  public function getSwitchLocationAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    $form = $this->createForm(new \Club\UserBundle\Form\SwitchLocation());
    $form->setData($user);

    return $this->render('ClubUserBundle:Misc:switchLocation.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/location_switch", name="switch_location")
   */
  public function switchLocationAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    $form = $this->createForm(new \Club\UserBundle\Form\SwitchLocation());
    $form->setData($user);
    $form->bindRequest($this->getRequest());

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getEntityManager();
      $em->persist($user);
      $em->flush();

      return $this->redirect($this->generateUrl('homepage'));
    }
  }
}
