<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="user")
   */
  public function indexAction()
  {
    $this->get('session')->setLocale('da_DK');

    $user = $this->get('security.context')->getToken()->getUser();
    $user = $this->getUser($user);

    $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
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
