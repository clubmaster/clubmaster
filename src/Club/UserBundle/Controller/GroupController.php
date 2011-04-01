<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;
use Club\UserBundle\Form\GroupForm;

class GroupController extends Controller
{
  public function indexAction()
  {
    $dql = "SELECT g FROM Club\UserBundle\Entity\Group g ORDER BY g.group_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $groups = $query->getResult();

    return $this->render('ClubUser:Group:index.html.twig',array(
      'page' => array('header' => 'User'),
      'groups' => $groups
    ));
  }

  public function newAction()
  {
    $group = new Group();
    $form = GroupForm::create($this->get('form.context'),'group');

    $form->bind($this->get('request'),$group);
    if ($form->isValid()) {
      $group->setGroupType('static');
      $group->setIsActive(true);
      $em = $this->get('doctrine.orm.entity_manager');
      $em->persist($group);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('group'));
    }

    return $this->render('ClubUser:Group:new.html.twig',array(
      'page' => array('header' => 'Group'),
      'form' => $form
    ));
  }

  public function editAction()
  {
  }

  public function deleteAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $group = $em->find('ClubUser:Group',$this->get('request')->get('id'));

    $em->remove($group);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Group %s deleted.',$group->getGroupName()));

    return new RedirectResponse($this->generateUrl('group'));
  }

  public function batchAction()
  {
  }
}
