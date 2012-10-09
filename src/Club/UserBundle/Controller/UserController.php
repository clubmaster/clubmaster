<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/{_locale}/user")
 */
class UserController extends Controller
{
  /**
   * @Template()
   * @Route("", name="user")
   * @Secure(roles="ROLE_USER")
   */
  public function indexAction()
  {
    $user = $this->buildUser();
    $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

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
   * @Route("/reset")
   */
  public function resetAction()
  {
    $user = $this->getUser();
    $form = $this->createFormBuilder($user)
      ->add('password', 'repeated', array(
        'type' => 'password',
        'first_name' => 'Password',
        'second_name' => 'Password_again',
        'required' => false
      ))
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

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

  /**
   * @Template()
   * @Route("/ical/{hash}")
   * @Secure(roles="ROLE_USER")
   */
  public function icalAction($hash)
  {
    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  protected function buildUser()
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getEntityManager();

    if (!$user->getProfile()->getProfileAddress()) {
      $address = new \Club\UserBundle\Entity\ProfileAddress();
      $address->setContactType('home');
      $address->setProfile($user->getProfile());
      $user->getProfile()->setProfileAddress($address);
    }
    if (!$user->getProfile()->getProfilePhone()) {
      $phone = new \Club\UserBundle\Entity\ProfilePhone();
      $phone->setContactType('home');
      $phone->setProfile($user->getProfile());
      $user->getProfile()->setProfilePhone($phone);
    }
    if (!$user->getProfile()->getProfileEmail()) {
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setContactType('home');
      $email->setProfile($user->getProfile());
      $user->getProfile()->setProfileEmail($email);
      $user->getProfile()->addProfileEmail($email);
    }

    return $user;
  }
}
