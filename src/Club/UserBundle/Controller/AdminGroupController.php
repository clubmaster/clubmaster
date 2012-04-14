<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;
use Club\UserBundle\Form\GroupForm;

class AdminGroupController extends Controller
{
  /**
   * @Route("/group", name="admin_group")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $groups = $em->getRepository('ClubUserBundle:Group')->findBy(array(),
      array('group_name'=>'ASC')
    );

    return array(
      'groups' => $groups
    );
  }

  /**
   * @Route("/group/members/{id}")
   * @Template()
   */
  public function membersAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $group = $em->find('ClubUserBundle:Group', $id);

    return array(
      'group' => $group
    );
  }

  /**
   * @Route("/group/new", name="admin_group_new")
   * @Template()
   */
  public function newAction()
  {
    $group = new Group();
    $group->setGroupType('dynamic');

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
    $em = $this->getDoctrine()->getEntityManager();
    $group = $em->find('ClubUserBundle:Group',$id);
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
    $em = $this->getDoctrine()->getEntityManager();
    $group = $em->find('ClubUserBundle:Group',$id);

    $em->remove($group);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_group'));
  }

  protected function process($group)
  {
    $form = $this->createForm(new \Club\UserBundle\Form\Group(), $group);

    if ($this->getRequest()->getMethod() == 'POST') {

      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        if ($group->getActiveMember() == '')
          $group->setActiveMember(null);
        if ($group->getGender() == '')
          $group->setGender(null);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($group);
        $em->flush();

        $event = new \Club\UserBundle\Event\FilterGroupEvent($group);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onGroupEdit, $event);

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_group'));
      }
    }

    return $form;
  }
}
