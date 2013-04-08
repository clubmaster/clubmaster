<?php

namespace Club\ExchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/exchange")
 */
class ExchangeController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $market = $em->getRepository('ClubExchangeBundle:Exchange')->getComing();

    return array(
      'market' => $market
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction(\Club\ExchangeBundle\Entity\Exchange $exchange)
  {
    $form = $this->createForm(new \Club\ExchangeBundle\Form\Exchange(), $exchange);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($exchange);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_exchange_exchange_index'));
      }
    }

    return array(
      'exchange' => $exchange,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $exchange = new \Club\ExchangeBundle\Entity\Exchange();
    $exchange->setUser($this->getUser());

    $form = $this->createForm(new \Club\ExchangeBundle\Form\Exchange(), $exchange);
    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($exchange);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_exchange_exchange_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   * @Template()
   */
  public function deleteAction(\Club\ExchangeBundle\Entity\Exchange $exchange)
  {
    $em = $this->getDoctrine()->getManager();

    $exchange->setClosed(true);
    $em->persist($exchange);
    $em->flush();

    $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_exchange_exchange_index'));
  }
}
