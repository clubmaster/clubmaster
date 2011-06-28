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
    $form = $this->createForm(new \Club\UserBundle\Form\RequestPassword());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      $post = $form->getData();

      $em = $this->getDoctrine()->getEntityManager();
      $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array(
        'member_number' => $post['username']
      ));

      if (!($user instanceOf \Club\UserBundle\Entity\User)) {
        $email = $em->getRepository('ClubUserBundle:ProfileEmail')->findOneBy(array(
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

        $event = new \Club\UserBundle\Event\FilterForgotPasswordEvent($forgot);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onPasswordReset, $event);
      }

      return $this->redirect($this->generateUrl('login'));
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
    $forgot = $em->getRepository('ClubUserBundle:ForgotPassword')->findOneByHash($hash);

    if ($forgot instanceOf \Club\UserBundle\Entity\ForgotPassword) {
      if ($this->getRequest()->getMethod() == 'POST') {
        $user = $forgot->getUser();
      } else {
        $user = new \Club\UserBundle\Entity\User();
      }
      $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\ForgotPassword(), $user);

      if ($this->getRequest()->getMethod() == 'POST') {
        $form->bindRequest($this->getRequest());

        if ($form->isValid()) {
          $forgot->setExpireDate(new \DateTime());

          $em->persist($user);
          $em->persist($forgot);
          $em->flush();

          $this->get('session')->set('notice','Your password has been set.');
          return $this->redirect($this->generateUrl('homepage'));
        }
      }

      return array(
        'form' => $form->createView(),
        'forgot' => $forgot
      );
    }
  }

  /**
   * @Route("/auth/register")
   * @Template()
   */
  public function registerAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = new \Club\UserBundle\Entity\User();
    $profile = new \Club\UserBundle\Entity\Profile();
    $user->setProfile($profile);
    $profile->setUser($user);
    $user = $this->getUser($user);
    $user->setMemberNumber($em->getRepository('ClubUserBundle:User')->findNextMemberNumber());

    $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your account has been created');

        $event = new \Club\UserBundle\Event\FilterUserEvent($user);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onUserNew, $event);

        return $this->redirect($this->generateUrl('homepage'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/auth/activate/{hash}")
   * @Template()
   */
  public function activateAction($hash)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array(
      'activation_code' => $hash
    ));

    if (!$user)
      return $this->redirect($this->generateUrl('homepage'));

    $form = $this->createForm(new \Club\UserBundle\Form\ActivateUser(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $user->setActivationCode(null);
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your account has been activated');

        $event = new \Club\UserBundle\Event\FilterUserEvent($user);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onUserActivate, $event);

        return $this->redirect($this->generateUrl('homepage'));
      }
    }

    return array(
      'form' => $form->createView(),
      'user' => $user
    );
  }


  protected function getUser($user)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if (!count($user->getProfile()->getProfileAddress())) {
      $address = new \Club\UserBundle\Entity\ProfileAddress();
      $address->setIsDefault(1);
      $address->setContactType('home');
      $address->setProfile($user->getProfile());
      $user->getProfile()->addProfileAddress($address);
    }
    if (!count($user->getProfile()->getProfilePhone())) {
      $phone = new \Club\UserBundle\Entity\ProfilePhone();
      $phone->setIsDefault(1);
      $phone->setContactType('home');
      $phone->setProfile($user->getProfile());
      $user->getProfile()->addProfilePhone($phone);
    }
    if (!count($user->getProfile()->getProfileEmail())) {
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setIsDefault(1);
      $email->setContactType('home');
      $email->setProfile($user->getProfile());
      $user->getProfile()->addProfileEmail($email);
    }

    return $user;
  }
}
