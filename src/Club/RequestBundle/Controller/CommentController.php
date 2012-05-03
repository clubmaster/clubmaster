<?php

namespace Club\RequestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/playermarket/comment")
 */
class CommentController extends Controller
{
  /**
   * @Route("/new/{id}")
   * @Template()
   */
  public function newAction(\Club\RequestBundle\Entity\Request $request)
  {
    $comment = new \Club\RequestBundle\Entity\RequestComment();
    $comment->setUser($this->get('security.context')->getToken()->getUser());
    $comment->setRequest($request);

    $form = $this->createForm(new \Club\RequestBundle\Form\RequestComment(), $comment);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($comment);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_request_playermarket_index'));
      }
    }

    return array(
      'request' => $request,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/{id}")
   * @Template()
   */
  public function indexAction(\Club\RequestBundle\Entity\Request $request)
  {
    return array(
      'request' => $request,
    );
  }
}
