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
   * @Route("/forgot", name="auth_forgot")
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

      $em = $this->get('doctrine')->getEntityManager();
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
        $event = new \Club\UserBundle\Event\FilterUserEvent($user);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onPasswordReset, $event);
      }

      return new RedirectResponse($this->generateUrl('login'));
    }

    return array(
      'form' => $form->createView()
    );
  }
}
