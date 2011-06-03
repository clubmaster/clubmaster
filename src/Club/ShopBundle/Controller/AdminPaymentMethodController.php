<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPaymentMethodController extends Controller
{
  /**
   * @Route("/shop/payment_method", name="admin_shop_payment_method")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $payment_methods = $em->getRepository('\Club\ShopBundle\Entity\PaymentMethod')->findAll();

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
    $em = $this->get('doctrine.orm.entity_manager');
    $payment_method = $em->find('Club\ShopBundle\Entity\PaymentMethod',$id);

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
    $em = $this->get('doctrine.orm.entity_manager');
    $payment_method = $em->find('ClubShopBundle:PaymentMethod',$this->get('request')->get('id'));

    $em->remove($payment_method);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('PaymentMethod %s deleted.',$payment_method->getPaymentMethodName()));

    return new RedirectResponse($this->generateUrl('admin_shop_payment_method'));
  }

  /**
   * @Route("/shop/payment_method/batch", name="admin_shop_payment_method_batch")
   */
  public function batchAction()
  {
  }

  protected function process($payment_method)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\PaymentMethod(), $payment_method);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($payment_method);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_payment_method'));
      }
    }

    return $form;
  }
}
