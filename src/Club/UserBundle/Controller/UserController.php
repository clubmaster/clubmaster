<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class UserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="user")
   * @Secure(roles="ROLE_USER")
   */
  public function indexAction()
  {
    $user = $this->get('clubmaster.user')
      ->buildUser($this->get('security.context')->getToken()->getUser())
      ->get();

    $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  /**
   * @Template()
   * @Route("/user/reset")
   */
  public function resetAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    $form = $this->createFormBuilder($user)
      ->add('password', 'repeated', array(
        'type' => 'password',
        'first_name' => 'Password',
        'second_name' => 'Password_again',
        'required' => false
      ))
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);

        $reset = $em->getRepository('ClubUserBundle:ResetPassword')->findOneBy(array(
          'user' => $user->getId()
        ));
        $em->remove($reset);

        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }
}
