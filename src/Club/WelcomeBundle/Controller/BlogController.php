<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/{_locale}/welcome/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/show/{blog_id}")
     * @Template()
     */
    public function showAction($blog_id)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->find('ClubWelcomeBundle:Blog', $blog_id);

        return array(
            'blog' => $blog
        );
    }

    /**
     * @Route("/comment/{blog_id}")
     * @Template()
     */
    public function commentAction($blog_id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $blog = $em->find('ClubWelcomeBundle:Blog', $blog_id);

        $comment = new \Club\WelcomeBundle\Entity\Comment();
        $comment->setUser($this->getUser());
        $comment->setBlog($blog);

        $form = $this->createForm(new \Club\WelcomeBundle\Form\Comment, $comment);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em->persist($comment);

                $event = new \Club\WelcomeBundle\Event\FilterCommentEvent($comment);
                $this->get('event_dispatcher')->dispatch(\Club\WelcomeBundle\Event\Events::onBlogCommentNew, $event);

                $em->flush();

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('club_welcome_blog_show', array(
                    'blog_id' => $blog->getId()
                )));
            }
        }

        return array(
            'blog' => $blog,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

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
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $blog = $em->find('ClubWelcomeBundle:Blog',$id);
        $this->validateOwnership($blog);

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
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $blog = $em->find('ClubWelcomeBundle:Blog',$this->getRequest()->get('id'));
        $this->validateOwnership($blog);

        $em->remove($blog);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("", defaults={"page" = 1})
     * @Route("/{page}", name="welcome_blog_offset")
     *
     * @Template()
     */
    public function indexAction($page)
    {
        $results = 5;

        $em = $this->getDoctrine()->getManager();
        $paginator = $em->getRepository('ClubWelcomeBundle:Blog')->getPaginator($results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'welcome_blog_offset');

        return array(
            'enable_blog' => $this->container->getParameter('club_welcome.enable_blog'),
            'paginator' => $paginator
        );
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

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('club_welcome_blog_index'));
            }
        }

        return $form;
    }

    protected function validateOwnership(\Club\WelcomeBundle\Entity\Blog $blog)
    {
        if ($this->getUser() != $blog->getUser() && !$this->get('security.context')->isGranted('ROLE_ADMIN_BLOG'))
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException;
    }
}
