<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Club\UserBundle\Form\UserAjax;

/**
 * @Route("/{_locale}/members")
 */
class MemberController extends Controller
{
    /**
     * @Template()
     * @Route("/search")
     */
    public function searchAction()
    {
        $this->setHeader();

        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserAjax());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $user = $form->get('user')->getData();

                return $this->redirect($this->generateUrl('club_user_member_show', array('id' => $user->getId())));
            } else {
                $errors = $form->get('user')->getErrors();

                foreach ($errors as $error) {
                    $this->get('session')->getFlashBag()->add('error', $error->getMessage());
                }
            }
        }

        return $this->redirect($this->generateUrl('club_user_member_index'));
    }

    /**
     * @Template()
     * @Route("/{id}")
     */
    public function showAction(\Club\UserBundle\Entity\User $user)
    {
        $this->setHeader();

        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $event = new \Club\UserBundle\Event\FilterActivityEvent($user);
        $this->get('event_dispatcher')->dispatch(\Club\UserBundle\Event\Events::onMemberView, $event);

        return array(
            'user' => $user,
            'activities' => $event->getActivities()
        );
    }

    /**
     * @Template()
     * @Route("", defaults={"page" = 1 })
     * @Route("/page/{page}", name="club_user_members_page")
     */
    public function indexAction($page)
    {
        $this->setHeader();

        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $results = 50;

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserAjax());

        $paginator = $em->getRepository('ClubUserBundle:User')->getPaginator($results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'club_user_members_page');

        return array(
            'form' => $form->createView(),
            'paginator' => $paginator
        );
    }

    private function setHeader()
    {
        $this->get('club_extra.storage')->setPageImage('bundles/clublayout/images/icons/32x32/group.png');
        $this->get('club_extra.storage')->setPageHeader($this->get('translator')->trans('Members'));
    }
}
