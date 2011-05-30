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
    $em = $this->get('doctrine.orm.entity_manager');
    $users = $em->getRepository('Club\UserBundle\Entity\User')->findAllUsersOrdered();

    return array(
      'page' => array('header' => 'User'),
      'users' => $users
    );
  }

  /**
   * @Template()
   * @Route("/user/new", name="user_new")
   */
  public function newAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $user = new \Club\UserBundle\Entity\User();

    $user->setMemberNumber($em->getRepository('Club\UserBundle\Entity\User')->findNextMemberNumber());
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\User(),$user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {

        $profile = $user->getProfile()->getProfileAddress();
        $profile[0]->setIsDefault(1);

        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'page' => array('header' => 'User'),
      'form' => $form->createView()
    );
  }

  /**
   * @Template()
   * @Route("/user/edit/{id}", name="user_edit")
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\User(),$user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'page' => array('header' => 'User'),
      'user' => $user,
      'form' => $form->createView()
    );

  }

  /**
   * @Route("/user/delete/{id}", name="user_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUserBundle:User',$id);

    $em->remove($user);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('User %s deleted.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('user'));
  }

  /**
   * @Route("/user/batch", name="user_batch")
   */
  public function batchAction()
  {
  }

  /**
   * @Route("/user/ban/{id}", name="user_ban")
   */
  public function banAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUserBundle:User',$id);

    $ban = new \Club\UserBundle\Entity\Ban();
    $ban->setUser($this->get('security.context')->getToken()->getUser());
    $ban->setType('user');
    $ban->setValue($user->getId());
    $ban->setExpireDate(new \DateTime(date('Y-m-d',strtotime("+1 month"))));

    $em->persist($ban);
    $em->flush();

    $this->get('session')->setFlash('notice',sprintf('User %s banned.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('user'));
  }

  /**
   * @Route("/user/subscription/{id}",name="user_subscription")
   * @Template()
   */
  public function subscriptionAction($id)
  {
    $user = $this->get('doctrine.orm.entity_manager')->find('Club\UserBundle\Entity\User',$id);

    $subscriptions = $user->getSubscriptions();
    return array(
      'subscriptions' => $subscriptions
    );
  }

  /**
   * @Route("/user/ticket/{id}", name="user_ticket")
   * @Template()
   */
  public function ticketAction($id)
  {
    $user = $this->get('doctrine.orm.entity_manager')->find('Club\UserBundle\Entity\User',$id);

    $tickets = $user->getTicketCoupons();

    return array(
      'tickets' => $tickets
    );
  }

  /**
   * @Route("/user/shop/{id}", name="user_shop")
   */
  public function shopAction($id)
  {
    $cart = $this->get('cart');
    $cart->emptyCart();
    $cart->setUserId($id);

    return new RedirectResponse($this->generateUrl('shop'));
  }

  /**
   * @Route("/user/address/{id}", name="user_address")
   * @Template()
   */
  public function addressAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $address->setProfile($profile);
    $address->setIsDefault(1);

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\ProfileAddress(), $address);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($address);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/phone/{id}", name="user_phone")
   * @Template()
   */
  public function phoneAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $phone = new \Club\UserBundle\Entity\ProfilePhone();
    $phone->setProfile($profile);
    $phone->setIsDefault(1);

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\ProfilePhone(), $phone);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($phone);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/email/{id}", name="user_email")
   * @Template()
   */
  public function emailAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $email = new \Club\UserBundle\Entity\ProfileEmail();
    $email->setProfile($profile);
    $email->setIsDefault(1);

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\ProfileEmail(), $email);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($email);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/group/{id}", name="user_group")
   * @Template()
   */
  public function groupAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('\Club\UserBundle\Entity\User',$id);

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\UserGroup(), $user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  public function getUsernameAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    return new Response($user->getProfile()->getName());
  }
}
