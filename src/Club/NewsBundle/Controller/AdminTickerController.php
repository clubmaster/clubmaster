<?php

namespace Club\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/news")
 */
class AdminTickerController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $tickers = $em->getRepository('ClubNewsBundle:Ticker')->findAll();

    return array(
      'tickers' => $tickers
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $start = new \DateTime(date('Y-m-d 00:00:00'));
    $end = clone $start;
    $i = new \DateInterval('P1Y');
    $end->add($i);

    $user = $this->get('security.context')->getToken()->getUser();
    $ticker = new \Club\NewsBundle\Entity\Ticker();
    $ticker->setUser($user);

    $res = $this->process($ticker);

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
    $em = $this->getDoctrine()->getEntityManager();
    $ticker = $em->find('ClubNewsBundle:Ticker',$id);

    $res = $this->process($ticker);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'ticker' => $ticker,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getEntityManager();
      $ticker = $em->find('ClubNewsBundle:Ticker',$this->getRequest()->get('id'));

      $em->remove($ticker);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete ticker which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_news_adminticker_index'));
  }

  protected function process($ticker)
  {
    $form = $this->createForm(new \Club\NewsBundle\Form\Ticker(), $ticker);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticker);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_news_adminticker_index'));
      }
    }

    return $form;
  }
}
