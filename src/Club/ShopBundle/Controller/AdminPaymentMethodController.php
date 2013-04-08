<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminPaymentMethodController extends Controller
{
  /**
   * @Route("/shop/payment_method", name="admin_shop_payment_method")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $payment_methods = $em->getRepository('ClubShopBundle:PaymentMethod')->findAll();

    return array(
      'payment_methods' => $payment_methods
    );
  }

  /**
   * @Route("/shop/payment_method/new", name="admin_shop_payment_method_new")
   * @Template()
   */
  public function newAction()
  {
    $payment_method = new \Club\ShopBundle\Entity\PaymentMethod();
    $res = $this->process($payment_method);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/payment_method/edit/{id}", name="admin_shop_payment_method_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $payment_method = $em->find('ClubShopBundle:PaymentMethod',$id);

    $res = $this->process($payment_method);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'payment_method' => $payment_method,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/payment_method/delete/{id}", name="admin_shop_payment_method_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $payment_method = $em->find('ClubShopBundle:PaymentMethod',$this->getRequest()->get('id'));

    $em->remove($payment_method);
    $em->flush();

    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_shop_payment_method'));
  }

  protected function process($payment_method)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\PaymentMethod(), $payment_method);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($payment_method);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_payment_method'));
      }
    }

    return $form;
  }
}
