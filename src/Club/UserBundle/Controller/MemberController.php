<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/{_locale}/members")
 */
class MemberController extends Controller
{
  /**
   * @Template()
   * @Route("/search")
   * @Secure(roles="ROLE_USER")
   */
  public function searchAction()
  {
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
          $user = $form->get('user')->getData();

          return $this->redirect($this->generateUrl('club_user_member_show', array('id' => $user->getId())));
      } else {
          $errors = $form->get('user')->getErrors();

          foreach ($errors as $error) {
              $this->get('session')->getFlashBag()->add('error', $error->getMessage());
          }
      }
    }

    return $this->redirect($this->generateUrl('club_user_member_index'));
  }

  /**
   * @Template()
   * @Route("/{id}")
   * @Secure(roles="ROLE_USER")
   */
  public function showAction(\Club\UserBundle\Entity\User $user)
  {
    $event = new \Club\UserBundle\Event\FilterActivityEvent($user);
    $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onMemberView, $event);

    return array(
      'user' => $user,
      'activities' => $event->getActivities()
    );
  }

  /**
   * @Template()
   * @Route("", defaults={"page" = 1 })
   * @Route("/page/{page}", name="club_user_members_page")
   * @Secure(roles="ROLE_USER")
   */
  public function indexAction($page)
  {
      $results = 50;

      $em = $this->getDoctrine()->getManager();
      $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

      $paginator = $em->getRepository('ClubUserBundle:User')->getPaginator($results, $page);

      $nav = $this->get('club_paginator.paginator')
          ->init($results, count($paginator), $page, 'club_user_members_page');

      return array(
          'form' => $form->createView(),
          'paginator' => $paginator,
          'nav' => $nav
      );
  }
}
