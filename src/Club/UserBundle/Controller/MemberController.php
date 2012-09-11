<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  /**
   * @Template()
   * @Route("/members/")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    $users = $em->getRepository('ClubUserBundle:User')->getBySearch(array());

    return array(
      'form' => $form->createView(),
      'users' => $users
    );
  }

  /**
   * @Template()
   * @Route("/members/search")
   */
  public function searchAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
          $user = $form->get('user')->getData();
      }
    }
  }

  /**
   * @Template()
   * @Route("/members/{id}")
   */
  public function showAction(\Club\UserBundle\Entity\User $user)
  {
    $event = new \Club\UserBundle\Event\FilterOutputEvent();
    $event->setUser($user);
    $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onMemberView, $event);

    return array(
      'user' => $user,
      'output' => $event->getOutput()
    );
  }
}
