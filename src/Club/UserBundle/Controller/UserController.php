<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="user")
   */
  public function indexAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();

    if (!count($user->getProfile()->getProfileAddress())) {
      $address = new \Club\UserBundle\Entity\ProfileAddress();
      $address->setIsDefault(1);
      $address->setProfile($user->getProfile());
      $user->getProfile()->setProfileAddress($address);
    }
    if (!count($user->getProfile()->getProfilePhone())) {
      $phone = new \Club\UserBundle\Entity\ProfilePhone();
      $phone->setIsDefault(1);
      $phone->setProfile($user->getProfile());
      $user->getProfile()->setProfilePhone($phone);
    }
    if (!count($user->getProfile()->getProfileEmail())) {
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setIsDefault(1);
      $email->setProfile($user->getProfile());
      $user->getProfile()->setProfileEmail($email);
    }

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\User(), $user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));

      if ($form->isValid()) {
        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->persist($address);
        $em->persist($phone);
        $em->persist($email);
        $em->flush();

        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }
}
