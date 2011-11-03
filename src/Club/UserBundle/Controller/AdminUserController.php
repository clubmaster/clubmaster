<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserController extends Controller
{
  /**
   * @Route("/user", name="admin_user")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive($this->get('security.context')->getToken()->getUser());

    $order_by = array();
    $repository = $em->getRepository('ClubUserBundle:User');
    $usersCount = $repository->getUsersCount($filter);
    $paginator = new \Club\UserBundle\Helper\Paginator($usersCount, $this->generateUrl('admin_user'));

    if ('POST' === $this->getRequest()->getMethod() && isset($_POST['filter_order'])) {
        $order_by = array($_POST['filter_order'] => $_POST['filter_order_Dir']);
        $sort_direction = $_POST['filter_order_Dir'] == 'asc' ? 'desc' : 'asc';

        $this->get('session')->set('lang_list_order_by', $order_by);
        $this->get('session')->set('lang_list_sort_dir', $sort_direction);
    } else {

        if ($this->get('session')->get('admin_user_list_order_by') != null) {
            $order_by = $this->get('session')->get('admin_user_list_order_by');
        } else {
            $order_by = array('sort_order' => 'asc', 'id' => 'asc');
        }
        if ($this->get('session')->get('admin_user_list_sort_dir') != null) {
            $sort_direction = $this->get('session')->get('admin_user_list_sort_dir');
        } else {
            $sort_direction = 'desc';
        }
    }
    $users = $repository->getUsersListWithPagination($filter, $order_by, $paginator->getOffset(), $paginator->getLimit());

    return array(
      'users' => $users,
      'sort_dir' => $sort_direction,
      'paginator' => $paginator
    );
  }

  /**
   * @Template()
   * @Route("/user/new", name="admin_user_new")
   */
  public function newAction()
  {
    $user = $this->initUser();
    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/create", name="admin_user_create")
   * @Template()
   */
  public function createAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->initUser();
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

    return $this->render('ClubUserBundle:AdminUser:new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/user/edit/{id}", name="admin_user_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $em->find('ClubUserBundle:User',$id);
    $user = $this->getUser($user);

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
   * @Route("/user/delete/{id}", name="admin_user_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $em->remove($user);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/user/batch", name="admin_user_batch")
   */
  public function batchAction()
  {
    // FIXME, not a pretty symfony way
    $ids = $_POST['ids'];
    $em = $this->getDoctrine()->getEntityManager();

    foreach ($ids as $id=>$value) {
      $ban = $this->get('clubmaster.ban')->banUser($em->find('ClubUserBundle:User',$id));
    }

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/user/ban/{id}", name="admin_user_ban")
   */
  public function banAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ban = $this->get('clubmaster.ban')->banUser($em->find('ClubUserBundle:User',$id));

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/user/shop/{id}")
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
   * @Route("/user/group/{id}", name="admin_user_group")
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

  protected function initUser()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = new \Club\UserBundle\Entity\User();
    $user->setMemberNumber($em->getRepository('ClubUserBundle:User')->findNextMemberNumber());
    $profile = new \Club\UserBundle\Entity\Profile();

    $user->setProfile($profile);
    $profile->setUser($user);

    return $this->getUser($user);
  }

  protected function getUser($user)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if (!count($user->getProfile()->getProfileAddress())) {
      $address = new \Club\UserBundle\Entity\ProfileAddress();
      $address->setContactType('home');
      $address->setProfile($user->getProfile());
      $user->getProfile()->setProfileAddress($address);
    }
    if (!count($user->getProfile()->getProfilePhone())) {
      $phone = new \Club\UserBundle\Entity\ProfilePhone();
      $phone->setContactType('home');
      $phone->setProfile($user->getProfile());
      $user->getProfile()->setProfilePhone($phone);
    }
    if (!count($user->getProfile()->getProfileEmail())) {
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setContactType('home');
      $email->setProfile($user->getProfile());
      $user->getProfile()->setProfileEmail($email);
    }

    return $user;
  }
}
