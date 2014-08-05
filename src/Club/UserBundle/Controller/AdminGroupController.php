<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;
use Club\UserBundle\Form\GroupType;
use Club\UserBundle\Form\UserAjax;

/**
 * @Route("/{_locale}/admin/group")
 */
class AdminGroupController extends Controller
{
    /**
     * @Route("/members/add/{id}")
     * @Template()
     */
    public function membersAddAction(\Club\UserBundle\Entity\Group $group)
    {
        $form = $this->createForm(new UserAjax());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $user = $form->get('user')->getData();

                $group->addUsers($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('club_extra.flash')->addNotice();

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
        $em = $this->getDoctrine()->getManager();
        $user = $em->find('ClubUserBundle:User', $user_id);

        $group->removeUser($user);
        $em->persist($group);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

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
        $em = $this->getDoctrine()->getManager();
        $group = $em->find('ClubUserBundle:Group',$id);

        $em->remove($group);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('admin_group'));
    }

    protected function process($group)
    {
        $form = $this->createForm(new GroupType(), $group);

        if ($this->getRequest()->getMethod() == 'POST') {

            $form->bind($this->getRequest());
            if ($form->isValid()) {

                if ($group->getActiveMember() == '')
                    $group->setActiveMember(null);
                if ($group->getGender() == '')
                    $group->setGender(null);

                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();

                $event = new \Club\UserBundle\Event\FilterGroupEvent($group);
                $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onGroupEdit, $event);

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('admin_group'));
            }
        }

        return $form;
    }

    /**
     * @Route("", name="admin_group", defaults={"page" = 1})
     * @Route("/{page}")
     * @Template()
     */
    public function indexAction($page)
    {
        $results = 20;

        $em = $this->getDoctrine()->getManager();
        $paginator = $em->getRepository('ClubUserBundle:Group')->getPaginator($results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'club_user_admingroup_index');

        return array(
            'paginator' => $paginator
        );
    }
}
