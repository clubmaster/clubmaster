<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;

/**
 * @Route("/{_locale}/admin/group")
 */
class AdminGroupController extends Controller
{
  /**
   * @Route("", name="admin_group")
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
   * @Route("/members/add/{id}")
   * @Template()
   */
  public function membersAddAction(\Club\UserBundle\Entity\Group $group)
  {
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    if ($this->getRequest()->getMethod() == 'POST') {
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $user = $form->get('user')->getData();

            $group->addUsers($user);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

            return $this->redirect($this->generateUrl('club_user_admingroup_members', array(
                'id' => $group->getId()
            )));
        }
    }

    return array(
        'group' => $group,
        'form' => $form->createView()
    );
  }

  /**
   * @Route("/members/delete/{id}/{user_id}")
   * @Template()
   */
  public function membersDeleteAction(\Club\UserBundle\Entity\Group $group, $user_id)
  {
      $em = $this->getDoctrine()->getEntityManager();
      $user = $em->find('ClubUserBundle:User', $user_id);

      $group->removeUser($user);
      $em->persist($group);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

      return $this->redirect($this->generateUrl('club_user_admingroup_members', array(
          'id' => $group->getId()
      )));
  }

  /**
   * @Route("/members/{id}")
   * @Template()
   */
  public function membersAction(\Club\UserBundle\Entity\Group $group)
  {
    return array(
      'group' => $group
    );
  }

  /**
   * @Route("/new", name="admin_group_new")
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
   * @Route("/edit/{id}", name="admin_group_edit")
   * @Template()
   */
  public function editAction(\Club\UserBundle\Entity\Group $group)
  {
    $res = $this->process($group);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'group' => $group,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}", name="admin_group_delete")
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

      $form->bind($this->getRequest());
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
