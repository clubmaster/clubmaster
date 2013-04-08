<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/{_locale}/admin/welcome/blog")
 */
class AdminBlogController extends Controller
{
    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        $blog = new \Club\WelcomeBundle\Entity\Blog();
        $blog->setUser($this->getUser());

        $res = $this->process($blog);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'form' => $res->createView()
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->find('ClubWelcomeBundle:Blog',$id);

        $res = $this->process($blog);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'blog' => $blog,
            'form' => $res->createView()
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $blog = $em->find('ClubWelcomeBundle:Blog',$this->getRequest()->get('id'));

            $em->remove($blog);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));
        } catch (\PDOException $e) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You cannot delete blog which is already being used.'));
        }

        return $this->redirect($this->generateUrl('club_welcome_adminblog_index'));
    }

    protected function process($blog)
    {
        $form = $this->createForm(new \Club\WelcomeBundle\Form\Blog(), $blog);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($blog);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_welcome_adminblog_index'));
            }
        }

        return $form;
    }

    /**
     * @Route("", defaults={"page" = 1})
     * @Route("/{page}", name="club_welcome_adminblog_offset")
     * @Template()
     */
    public function indexAction($page)
    {
        $results = 20;

        $em = $this->getDoctrine()->getManager();
        $paginator = $em->getRepository('ClubWelcomeBundle:Blog')->getPaginator($results, $page);

        $nav = $this->get('club_paginator.paginator')
            ->init($results, count($paginator), $page, 'club_welcome_adminblog_offset');

        return array(
            'paginator' => $paginator,
            'nav' => $nav
        );
    }
}
