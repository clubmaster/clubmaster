<?php

namespace Club\ExchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/exchange/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/close/{id}")
     * @Template()
     */
    public function closeAction(\Club\ExchangeBundle\Entity\Exchange $exchange)
    {
        $em = $this->getDoctrine()->getManager();
        $exchange->setClosed(true);

        $em->persist($exchange);
        $em->flush();

        return $this->redirect($this->generateUrl('club_exchange_exchange_index'));
    }

    /**
     * @Route("/new/{id}")
     * @Template()
     */
    public function newAction(\Club\ExchangeBundle\Entity\Exchange $exchange)
    {
        if ($exchange->getClosed()) {
            $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot comment a closed exchange.'));
            return $this->redirect($this->generateUrl('club_exchange_comment_index', array(
                'id' => $exchange->getId()
            )));
        }

        $comment = new \Club\ExchangeBundle\Entity\ExchangeComment();
        $comment->setUser($this->getUser());
        $comment->setExchange($exchange);

        $form = $this->createForm(new \Club\ExchangeBundle\Form\ExchangeComment(), $comment);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $event = new \Club\ExchangeBundle\Event\FilterExchangeCommentEvent($comment, $this->getUser());
                $this->get('event_dispatcher')->dispatch(\Club\ExchangeBundle\Event\Events::onExchangeCommentNew, $event);

                $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_exchange_comment_index', array(
                    'id' => $exchange->getId()
                )));
            }
        }

        return array(
            'exchange' => $exchange,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction(\Club\ExchangeBundle\Entity\Exchange $exchange)
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('ClubExchangeBundle:ExchangeComment')->findBy(
            array('exchange' => $exchange->getId()),
            array('id' => 'DESC')
        );

        return array(
            'exchange' => $exchange,
            'comments' => $comments
        );
    }
}
