<?php

namespace Club\ExchangeBundle\Controller;

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
  public function newAction(\Club\ExchangeBundle\Entity\Request $request)
  {
    $comment = new \Club\ExchangeBundle\Entity\RequestComment();
    $comment->setUser($this->getUser());
    $comment->setRequest($request);

    $form = $this->createForm(new \Club\ExchangeBundle\Form\RequestComment(), $comment);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($comment);
        $em->flush();

        $event = new \Club\ExchangeBundle\Event\FilterRequestCommentEvent($comment);
        $this->get('event_dispatcher')->dispatch(\Club\ExchangeBundle\Event\Events::onRequestCommentNew, $event);

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
  public function indexAction(\Club\ExchangeBundle\Entity\Request $request)
  {
    return array(
      'request' => $request,
    );
  }
}
