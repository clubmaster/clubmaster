<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\User;
use Club\UserBundle\Entity\Profile;
use Club\UserBundle\Form\UserForm;
use Club\UserBundle\Entity\Ban;
use DateTime;

class UserController extends Controller
{
  /**
   * @extra:Template()
   * @extra:Route("/user", name="user")
   */
  public function indexAction()
  {
    $dql = "SELECT u FROM Club\UserBundle\Entity\User u ORDER BY u.username";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $users = $query->getResult();

    return array(
      'page' => array('header' => 'User'),
      'users' => $users
    );
  }

  /**
   * @extra:Template()
   * @extra:Route("/user/new", name="user_new")
   */
  public function newAction()
  {
    $user = new User();
    $form = UserForm::create($this->get('form.context'),'user');

    $form->bind($this->get('request'),$user);
    if ($form->isValid()) {
      $profile = new Profile();
      $profile->setUser($user);
      $user->setProfile($profile);

      $em = $this->get('doctrine.orm.entity_manager');
      $em->persist($user);
      $em->persist($profile);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');
    }

    return array(
      'page' => array('header' => 'User'),
      'form' => $form
    );
  }

  /**
   * @extra:Template()
   * @extra:Route("/user/edit/{id}", name="user_edit")
   */
  public function editAction($id)
  {
  }

  /**
   * @extra:Route("/user/delete/{id}", name="user_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUser:User',$id);

    $em->remove($user);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('User %s deleted.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('user'));
  }

  /**
   * @extra:Route("/user/batch", name="user_batch")
   */
  public function batchAction()
  {
  }

  /**
   * @extra:Route("/user/ban/{id}", name="user_ban")
   */
  public function banAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUser:User',$id);

    $ban = new Ban();
    $ban->setUserId(1);
    $ban->setType('user');
    $ban->setValue($user->getId());
    $ban->setExpireDate(new DateTime(date('Y-m-d')));

    $em->persist($ban);
    $em->flush();

    $this->get('session')->setFlash('notice',sprintf('User %s banned.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('user'));
  }
}
