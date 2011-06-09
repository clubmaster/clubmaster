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

    if ('POST' === $this->get('request')->getMethod()) {
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

    return array('users' => $users, 'sort_dir' => $sort_direction, 'paginator' => $paginator);

    /*
    $filter = $this->createForm(new \Club\UserBundle\Filter\User());
    $data = unserialize($this->get('session')->get('filter.admin_user'));
    $data = ($data) ? $data : new \Club\UserBundle\Entity\User();

    $filter->setData($data);

    $em = $this->get('doctrine')->getEntityManager();
    $users = $em->getRepository('Club\UserBundle\Entity\User')->getUsers($data);

    return array(
      'users' => $users,
      'filter_form' => $filter->createView()
    );
     */
  }

  /**
   * @Route("/user/filter", name="admin_user_filter")
   */
  public function filterAction()
  {
    $filter = new \Club\UserBundle\Entity\User();

    $form = $this->createForm(new \Club\UserBundle\Filter\User($filter));
    $form->bindRequest($this->get('request'));

    if ($form->isValid()) {
      $this->get('session')->set('filter.admin_user',serialize($form->getData()));
    }

    return $this->forward('ClubUserBundle:AdminUser:index');
  }

  /**
   * @Template()
   * @Route("/user/new", name="admin_user_new")
   */
  public function newAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $user = new \Club\UserBundle\Entity\User();

    $user->setMemberNumber($em->getRepository('Club\UserBundle\Entity\User')->findNextMemberNumber());

    $profile = new \Club\UserBundle\Entity\Profile();
    $user->setProfile($profile);
    $profile->setUser($user);

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

    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\AdminUser(),$user);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {

        $profile = $user->getProfile()->getProfileAddress();
        $profile[0]->setIsDefault(1);

        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_user'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Template()
   * @Route("/user/edit/{id}", name="admin_user_edit")
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\AdminUser(),$user);

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

    return new RedirectResponse($this->generateUrl('user'));
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

    return new RedirectResponse($this->generateUrl('user'));
  }

  /**
   * @Route("/user/subscription/{id}",name="admin_user_subscription")
   * @Template()
   */
  public function subscriptionAction($id)
  {
    $user = $this->get('doctrine.orm.entity_manager')->find('Club\UserBundle\Entity\User',$id);

    return array(
      'user' => $user
    );
  }

  /**
   * @Route("/user/subscription/expire/{id}",name="admin_user_subscription_expire")
   */
  public function subscriptionExpireAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $subscription = $em->find('\Club\ShopBundle\Entity\Subscription',$id);
    $subscription->expire(new \DateTime());

    $em->persist($subscription);
    $em->flush();

    return new RedirectResponse($this->generateUrl('user_subscription',array('id'=>$subscription->getUser()->getId())));
  }

  /**
   * @Route("/user/ticket/expire/{id}",name="admin_user_ticket_expire")
   */
  public function ticketExpireAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $ticket = $em->find('\Club\ShopBundle\Entity\TicketCoupon',$id);
    $ticket->expire(new \DateTime());

    $em->persist($ticket);
    $em->flush();

    return new RedirectResponse($this->generateUrl('user_subscription',array('id'=>$ticket->getUser()->getId())));
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
   * @Route("/user/group/{id}", name="admin_user_group")
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
}
