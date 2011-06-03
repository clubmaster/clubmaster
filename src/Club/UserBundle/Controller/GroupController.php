<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;
use Club\UserBundle\Form\GroupForm;

class GroupController extends Controller
{
  /**
   * @Route("/group", name="admin_group")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $groups = $em->getRepository('\Club\UserBundle\Entity\Group')->findAll();

    return $this->render('ClubUserBundle:Group:index.html.twig',array(
      'groups' => $groups
    ));
  }

  /**
   * @Route("/group/new", name="admin_group_new")
   * @Template()
   */
  public function newAction()
  {
    $group = new Group();
    $group->setIsActive(1);
    $res = $this->process($group);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/group/edit/{id}", name="admin_group_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $group = $em->find('Club\UserBundle\Entity\Group',$id);
    $res = $this->process($group);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'group' => $group,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/group/delete/{id}", name="admin_group_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $group = $em->find('ClubUserBundle:Group',$id);

    $em->remove($group);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Group %s deleted.',$group->getGroupName()));

    return new RedirectResponse($this->generateUrl('admin_group'));
  }

  /**
   * @Route("/group/batch", name="admin_group_batch")
   */
  public function batchAction()
  {
  }

  protected function process($group)
  {
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\Group(), $group);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($group);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_group'));
      }
    }

    return $form;
  }
}
