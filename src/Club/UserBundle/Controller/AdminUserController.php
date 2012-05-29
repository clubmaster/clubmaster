<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/user")
 */
class AdminUserController extends Controller
{
  /**
   * @Route("/export/csv")
   */
  public function csvAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive($this->get('security.context')->getToken()->getUser());
    $users = $em->getRepository('ClubUserBundle:User')->getUsersListWithPagination($filter);;

    // field delimiter
    $fd = "\t";
    // row delimiter
    $rd = PHP_EOL;
    // text delimiter
    $td = '"';

    $r =
      $td.'Member number'.$td.$fd.
      $td.'First name'.$td.$fd.
      $td.'Last name'.$td.$fd.
      $td.'Gender'.$td.$fd.
      $td.'Day of birth'.$td.$fd.
      $td.'Street'.$td.$fd.
      $td.'Postal'.$td.$fd.
      $td.'City'.$td.$fd.
      $td.'Country'.$td.$fd.
      $td.'Email'.$td.$fd.
      $td.'Phone'.$td.$rd;

    foreach ($users as $user) {
      $profile = $user->getProfile();
      $address = $profile->getProfileAddress();
      $email = $profile->getProfileEmail();
      $phone = $profile->getProfilePhone();

      $r .=
        $td.$user->getMemberNumber().$td.$fd.
        $td.$profile->getFirstName().$td.$fd.
        $td.$profile->getLastName().$td.$fd.
        $td.$profile->getGender().$td.$fd.
        $td.$profile->getDayOfBirth()->format('Y-m-d').$td.$fd;

      if ($address) {
        $r .=
          $td.trim($address->getStreet()).$td.$fd.
          $td.$address->getPostalCode().$td.$fd.
          $td.$address->getCity().$td.$fd.
          $td.$address->getCountry().$td.$fd;
      } else {
        $r .= $fd.$fd.$fd.$fd;
      }

      if ($email) {
        $r .= $td.$email->getEmailAddress().$td.$fd;
      } else {
        $r .= $fd;
      }

      if ($phone)
        $r .= $td.$phone->getPhoneNumber().$td;

      $r .= $rd;
    }

    $response = new Response($r);
    $response->headers->set('Content-Disposition', 'attachment;filename=clubmaster_members.csv');

    return $response;
  }

  /**
   * @Template()
   * @Route("/new", name="admin_user_new")
   */
  public function newAction()
  {
    $user = $this->get('clubmaster.user')->get();
    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/create", name="admin_user_create")
   * @Template()
   */
  public function createAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->get('clubmaster.user')->get();
    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $profile = $user->getProfile();

        if ($profile->getProfileEmail()->getEmailAddress() == '') $profile->setProfileEmail(null);
        if ($profile->getProfilePhone()->getPhoneNumber() == '') $profile->setProfilePhone(null);

        $this->get('clubmaster.user')->save();
        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_user'));
      }
    }

    return $this->render('ClubUserBundle:AdminUser:new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/edit/{id}", name="admin_user_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $em->find('ClubUserBundle:User',$id);
    $user = $this->get('clubmaster.user')
      ->buildUser($user)
      ->get();

    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($user->getProfile()->getProfileEmail()->getEmailAddress() == '')
        $user->getProfile()->setProfileEmail(null);
      if ($user->getProfile()->getProfilePhone()->getPhoneNumber() == '')
        $user->getProfile()->setProfilePhone(null);

      if ($form->isValid()) {
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/batch", name="admin_user_batch")
   */
  public function batchAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ids = $this->getRequest()->get('ids');

    $form = $this->createForm(new \Club\UserBundle\Form\Batch());
    $form->bindRequest($this->getRequest());
    if ($form->isValid()) {

      $r = $form->getData();
      switch ($r['batch']) {
      case 'ban':
        foreach ($ids as $id => $value) {
          $this->get('clubmaster.ban')->banUser($em->find('ClubUserBundle:User',$id));
        }
        break;
      case 'password_expire':
        foreach ($ids as $id => $value) {
          $this->get('club_user.reset_password')->passwordExpire($em->find('ClubUserBundle:User',$id));
        }
        break;
      case 'subscription_expire':
        foreach ($ids as $id => $value) {
          $this->get('subscription')->expireAllSubscriptions($em->find('ClubUserBundle:User',$id));
        }
        break;
      }

      $em->flush();
      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    }

    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/ban/{id}", name="admin_user_ban")
   */
  public function banAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ban = $this->get('clubmaster.ban')->banUser($em->find('ClubUserBundle:User',$id));

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/shop/{id}")
   */
  public function shopAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $this->get('session')->set('cart_id',null);
    $cart = $this->get('cart');
    $cart->getCart()->setUser($user);
    $cart->setAddresses($user->getProfile()->getProfileAddress());

    return $this->redirect($this->generateUrl('shop'));
  }

  /**
   * @Route("/log/{id}")
   * @Template()
   */
  public function logAction(\Club\UserBundle\Entity\User $user)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $logs = $em->getRepository("ClubLogBundle:Log")->getByUser($user);

    return array(
      'user' => $user,
      'logs' => $logs
    );
  }

  /**
   * @Route("/group/{id}", name="admin_user_group")
   * @Template()
   */
  public function groupAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $form = $this->createForm(new \Club\UserBundle\Form\UserGroup(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        foreach ($user->getGroups() as $group) {
          $group = $em->find('ClubUserBundle:Group',$group->getId());
          $group->addUsers($user);
          $em->persist($group);
        }
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/sort/{name}/{type}")
   */
  public function sortAction($name, $type)
  {
    $filter = $this->get('session')->get('admin_module:admin_user');
    $filter['sort'] = array($name => $type);
    $this->get('session')->set('admin_module:admin_user', $filter);

    return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
  }

  /**
   * @Route("/", name="admin_user")
   * @Route("/offset/{offset}", name="admin_user_offset")
   * @Template()
   */
  public function indexAction($offset = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive($this->get('security.context')->getToken()->getUser());

    $repository = $em->getRepository('ClubUserBundle:User');
    $usersCount = $repository->getUsersCount($filter);

    $paginator = $this->get('club_paginator.paginator');
    $paginator->init($usersCount, $offset);
    $paginator->setCurrentUrl('admin_user_offset');

    $sort = $this->get('session')->get('admin_module:admin_user');

    if (isset($sort) && isset($sort['sort'])) {
      $order_by = $sort['sort'];
    } else {
      $order_by = array('member_number' => 'asc');
    }

    $form = $this->createForm(new \Club\UserBundle\Form\Batch());

    $users = $repository->getUsersListWithPagination($filter, $order_by, $paginator->getOffset(), $paginator->getLimit());

    return array(
      'sort_name' => key($order_by),
      'sort_type' => $order_by[key($order_by)],
      'users' => $users,
      'paginator' => $paginator,
      'form' => $form->createView()
    );
  }
}
