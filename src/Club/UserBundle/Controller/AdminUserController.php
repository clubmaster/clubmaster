<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminUserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="admin_user")
   */
  public function indexAction()
  {
    $order_by = array();
    $em = $this->get('doctrine.orm.entity_manager');
    $repository = $em->getRepository('\Club\UserBundle\Entity\User');
    $usersCount = $repository->getUsersCount();
    $paginator = new \Club\UserBundle\Helper\Paginator($usersCount, $this->generateUrl('admin_user'));

    if ('POST' === $this->get('request')->getMethod() && isset($_POST['filter_order'])) {
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
    $users = $repository->getUsersListWithPagination($order_by, $paginator->getOffset(), $paginator->getLimit());

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
    $em = $this->get('doctrine.orm.entity_manager');

    $user = $this->initUser();
    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));

      // validate user
      $errors = $this->get('validator')->validate($user);
      if (count($errors) > 0) {
        return $this->render('ClubUserBundle:AdminUser:new.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate profile
      $errors = $this->get('validator')->validate($user->getProfile());
      if (count($errors) > 0) {
        return $this->render('ClubUserBundle:AdminUser:new.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate address
      $addresses = $user->getProfile()->getProfileAddress();
      if (count($this->get('validator')->validate($addresses[0])) > 0) {
        return $this->render('ClubUserBundle:AdminUser:new.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate email
      $emails = $user->getProfile()->getProfileEmail();
      if (count($this->get('validator')->validate($emails[0])) > 0) {
        $user->getProfile()->getProfileEmail()->removeElement($emails[0]);
      }

      // validate phone
      $phones = $user->getProfile()->getProfilePhone();
      if (count($this->get('validator')->validate($phones[0])) > 0) {
        $user->getProfile()->getProfilePhone()->removeElement($phones[0]);
      }

      $em->persist($user);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');
      return new RedirectResponse($this->generateUrl('admin_user'));
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
    $em = $this->get('doctrine')->getEntityManager();

    $user = $em->find('ClubUserBundle:User',$id);
    $user = $this->getUser($user);

    $form = $this->createForm(new \Club\UserBundle\Form\AdminUser(),$user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));

      // validate user
      $errors = $this->get('validator')->validate($user);
      if (count($errors) > 0) {
        return $this->render('ClubUserBundle:AdminUser:edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate profile
      $errors = $this->get('validator')->validate($user->getProfile());
      if (count($errors) > 0) {
        return $this->render('ClubUserBundle:AdminUser:edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate address
      $addresses = $user->getProfile()->getProfileAddress();
      if (count($this->get('validator')->validate($addresses[0])) > 0) {
        return $this->render('ClubUserBundle:AdminUser:edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

      // validate email
      $emails = $user->getProfile()->getProfileEmail();
      if (count($this->get('validator')->validate($emails[0])) > 0) {
        $user->getProfile()->getProfileEmail()->removeElement($emails[0]);
      }

      // validate phone
      $phones = $user->getProfile()->getProfilePhone();
      if (count($this->get('validator')->validate($phones[0])) > 0) {
        $user->getProfile()->getProfilePhone()->removeElement($phones[0]);
      }

      $em->persist($user);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');
      return new RedirectResponse($this->generateUrl('admin_user'));
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
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUserBundle:User',$id);

    $em->remove($user);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('User %s deleted.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/user/batch", name="admin_user_batch")
   */
  public function batchAction()
  {
  }

  /**
   * @Route("/user/ban/{id}", name="admin_user_ban")
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

    return new RedirectResponse($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/user/shop/{id}", name="admin_user_shop")
   */
  public function shopAction($id)
  {
    $cart = $this->get('cart');
    $cart->emptyCart();
    $cart->setUserId($id);

    return new RedirectResponse($this->generateUrl('shop'));
  }

  /**
   * @Route("/user/address/{id}", name="admin_user_address")
   * @Template()
   */
  public function addressAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $address->setProfile($profile);
    $address->setIsDefault(1);

    $form = $this->createForm(new \Club\UserBundle\Form\ProfileAddress(), $address);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($address);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('admin_user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/phone/{id}", name="admin_user_phone")
   * @Template()
   */
  public function phoneAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $phone = new \Club\UserBundle\Entity\ProfilePhone();
    $phone->setProfile($profile);
    $phone->setIsDefault(1);

    $form = $this->createForm(new \Club\UserBundle\Form\ProfilePhone(), $phone);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($phone);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('admin_user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/email/{id}", name="admin_user_email")
   * @Template()
   */
  public function emailAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $profile = $em->find('\Club\UserBundle\Entity\Profile',$id);

    $email = new \Club\UserBundle\Entity\ProfileEmail();
    $email->setProfile($profile);
    $email->setIsDefault(1);

    $form = $this->createForm(new \Club\UserBundle\Form\ProfileEmail(), $email);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($email);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('admin_user'));
      }
    }

    return array(
      'profile' => $profile,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/user/group/{id}", name="admin_user_group")
   * @Template()
   */
  public function groupAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('\Club\UserBundle\Entity\User',$id);

    $form = $this->createForm(new \Club\UserBundle\Form\UserGroup(), $user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
        return new RedirectResponse($this->generateUrl('admin_user'));
      }
    }

    return array(
      'user' => $user,
      'form' => $form->createView()
    );
  }

  protected function initUser()
  {
    $em = $this->get('doctrine')->getEntityManager();

    $user = new \Club\UserBundle\Entity\User();
    $user->setMemberNumber($em->getRepository('ClubUserBundle:User')->findNextMemberNumber());
    $profile = new \Club\UserBundle\Entity\Profile();

    $user->setProfile($profile);
    $profile->setUser($user);

    return $this->getUser($user);
  }

  protected function getUser($user)
  {
    $em = $this->get('doctrine')->getEntityManager();

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
