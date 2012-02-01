<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="user")
   */
  public function indexAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    $user = $this->getUser($user);

    $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        $this->get('session')->setLocale($user->getLanguage()->getCode());
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
    }

    return $user;
  }
}
