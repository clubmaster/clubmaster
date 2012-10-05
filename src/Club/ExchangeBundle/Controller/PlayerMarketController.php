<?php

namespace Club\ExchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/playermarket")
 */
class PlayerMarketController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $market = $em->getRepository('ClubExchangeBundle:Request')->getOpen();

    return array(
      'market' => $market
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction(\Club\ExchangeBundle\Entity\Request $request)
  {
    $form = $this->createForm(new \Club\ExchangeBundle\Form\Request(), $request);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($request);
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
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $request = new \Club\ExchangeBundle\Entity\Request();
    $request->setUser($this->getUser());

    $form = $this->createForm(new \Club\ExchangeBundle\Form\Request(), $request);
    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($request);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_request_playermarket_index'));
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
  public function deleteAction(\Club\ExchangeBundle\Entity\Request $request)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $request->setClosed(true);
    $em->persist($request);
    $em->flush();

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_request_playermarket_index'));
  }
}
