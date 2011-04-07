<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Role;
use Club\UserBundle\Form\RoleForm;

class RoleController extends Controller
{
  /**
   * @extra:Template()
   * @extra:Route("/role", name="role")
   */
  public function indexAction()
  {
    $dql = "SELECT r FROM Club\UserBundle\Entity\Role r ORDER BY r.role_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $roles = $query->getResult();

    return $this->render('ClubUserBundle:Role:index.html.twig',array(
      'page' => array('header' => 'User'),
      'roles' => $roles
    ));
  }

  /**
   * @extra:Template()
   * @extra:Route("/role/new", name="role_new")
   */
  public function newAction()
  {
    $role = new Role();
    $form = RoleForm::create($this->get('form.context'),'role');

    $form->bind($this->get('request'),$role);
    if ($form->isValid()) {
      $em = $this->get('doctrine.orm.entity_manager');
      $em->persist($role);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('role'));
    }

    return $this->render('ClubUserBundle:Role:new.html.twig',array(
      'page' => array('header' => 'Role'),
      'form' => $form
    ));
  }

  /**
   * @extra:Template()
   * @extra:Route("/role/edit/{id}", name="role_edit")
   */
  public function editAction($id)
  {
  }

  /**
   * @extra:Route("/role/delete/{id}", name="role_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $role = $em->find('ClubUserBundle:Role',$id);

    $em->remove($role);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Role %s deleted.',$role->getRoleName()));

    return new RedirectResponse($this->generateUrl('role'));
  }

  /**
   * @extra:Route("/role/batch", name="role_batch")
   */
  public function batchAction()
  {
  }
}
