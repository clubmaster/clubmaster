<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Club\UserBundle\Entity\User;
use Club\UserBundle\Form\UserForm;

class DefaultController extends Controller
{
    public function indexAction()
    {
      return $this->render('ClubUser:Default:index.html.twig',array(
        'page' => array('header' => 'User'),
        'users' => array()
      ));
    }

    public function newAction()
    {
      $user = new User();
      $form = UserForm::create($this->get('form.context'),'user');

      return $this->render('ClubUser:Default:new.html.twig',array(
        'page' => array('header' => 'User'),
        'form' => $form
      ));
    }

    public function createAction()
    {
      $user = new User();
      $form = UserForm::create($this->get('form.context'),'user');

      $form->bind($this->get('request'),$user);
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($user);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');
      }

      return $this->render('ClubUser:Default:new.html.twig',array(
        'page' => array('header' => 'User'),
        'form' => $form
      ));
    }
}
