<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\User;
use Club\UserBundle\Entity\Profile;
use Club\UserBundle\Form\UserForm;
use Club\UserBundle\Entity\Ban;
use DateTime;

class DefaultController extends Controller
{
  public function indexAction()
  {
    $dql = "SELECT u FROM Club\UserBundle\Entity\User u ORDER BY u.username";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $users = $query->getResult();

    return $this->render('ClubUser:Default:index.html.twig',array(
      'page' => array('header' => 'User'),
      'users' => $users
    ));
  }

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

    return $this->render('ClubUser:Default:index.html.twig',array(
      'page' => array('header' => 'User'),
      'form' => $form
    ));
  }

  public function editAction()
  {
  }

  public function deleteAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUser:User',$this->get('request')->get('id'));

    $em->remove($user);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('User %s deleted.',$user->getUsername()));

    return new RedirectResponse($this->generateUrl('user'));
  }

  public function batchAction()
  {
  }

  public function banAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('ClubUser:User',$this->get('request')->get('id'));

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
