<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
  /**
   * @Route("/login",name="login")
   * @Template()
   */
  public function loginAction()
  {
    return array();
  }

  /**
   * @Route("/auth/forgot", name="auth_forgot")
   * @Template()
   */
  public function forgotAction()
  {
    $form = $this->createFormBuilder()
      ->add('username','text',array('required' => false))
      ->add('email','text',array('required' => false))
      ->getForm();

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));

      $post = $form->getData();

      $em = $this->getDoctrine()->getEntityManager();
      $user = $em->getRepository('\Club\UserBundle\Entity\User')->findOneBy(array(
        'member_number' => $post['username']
      ));

      if (!($user instanceOf \Club\UserBundle\Entity\User)) {
        $email = $em->getRepository('\Club\UserBundle\Entity\ProfileEmail')->findOneBy(array(
          'email_address' => $post['email']
        ));

        if ($email instanceOf \Club\UserBundle\Entity\ProfileEmail) {
          $user = $email->getProfile()->getUser();
        }
      }

      if ($user instanceOf \Club\UserBundle\Entity\User) {
        $forgot = new \Club\UserBundle\Entity\ForgotPassword();
        $forgot->setUser($user);
        $em->persist($forgot);
        $em->flush();

        $event = new \Club\UserBundle\Event\FilterUserEvent($user, $forgot);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onPasswordReset, $event);
      }

      return new RedirectResponse($this->generateUrl('login'));
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/auth/reset/{hash}", name="auth_reset")
   * @Template()
   */
  public function resetPasswordAction($hash)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $forgot = $em->getRepository('\Club\UserBundle\Entity\ForgotPassword')->findOneByHash($hash);

    if ($forgot instanceOf \Club\UserBundle\Entity\ForgotPassword) {
      if ($this->get('request')->getMethod() == 'POST') {
        $user = $forgot->getUser();
      } else {
        $user = new \Club\UserBundle\Entity\User();
      }
      $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\ForgotPassword(), $user);

      if ($this->get('request')->getMethod() == 'POST') {
        $form->bindRequest($this->get('request'));

        if ($form->isValid()) {
          $forgot->setExpireDate(new \DateTime());

          $em->persist($user);
          $em->persist($forgot);
          $em->flush();

          $this->get('session')->set('notice','Your password has been set.');
          return new RedirectResponse($this->generateUrl('homepage'));
        }
      }

      return array(
        'form' => $form->createView(),
        'forgot' => $forgot
      );
    }
  }
}
