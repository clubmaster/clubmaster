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
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\User(), $user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));

      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
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
