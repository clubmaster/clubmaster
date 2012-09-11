<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class CurrencyController extends Controller
{
  /**
   * @Template()
   * @Route("/currency", name="admin_currency")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $currencies = $em->getRepository('ClubUserBundle:Currency')->findAll();

    return array(
      'currencies' => $currencies
    );
  }

  /**
   * @Route("/currency/new", name="admin_currency_new")
   * @Template()
   */
  public function newAction()
  {
    $currency = new \Club\UserBundle\Entity\Currency();
    $res = $this->process($currency);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/currency/edit/{id}", name="admin_currency_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $currency = $em->find('ClubUserBundle:Currency',$id);
    $res = $this->process($currency);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView(),
      'currency' => $currency
    );
  }

  /**
   * @Route("/currency/delete/{id}", name="admin_currency_delete")
   * @Template()
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $currency = $em->find('ClubUserBundle:Currency',$id);

    $em->remove($currency);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_currency'));
  }

  protected function process($currency)
  {
    $form = $this->createForm(new \Club\UserBundle\Form\Currency(), $currency);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($currency);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_currency'));
      }
    }

    return $form;
  }
}
