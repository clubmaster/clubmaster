<?php

namespace Club\Payment\CashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CashController extends Controller
{
    /**
     * @Route("/cash/register/{order_id}")
     * @Template()
     */
    public function registerAction($order_id)
    {
      $em = $this->getDoctrine()->getEntityManager();
      $order = $em->find('ClubShopBundle:Order', $order_id);

      $payment = $em->getRepository('ClubShopBundle:PaymentMethod')->findOneBy(array(
        'controller' => $this->container->getParameter('club_payment_quickpay.controller')
      ));
      $log = new \Club\ShopBundle\Entity\PurchaseLog();
      $log->setOrder($order);
      $log->setPaymentMethod($payment);
      $log->setAmount($order->getPrice());
      $log->setAccepted(true);
      $log->setCurrency('DKK');

      $form = $this->createFormBuilder($log)
        ->add('amount')
        ->getForm();

      if ($this->getRequest()->getMethod() == 'POST') {
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
          $log->setAmount($log->getAmount()*100);
          $em->persist($log);
          $em->flush();

          $this->get('order')->setOrder($order);
          $this->get('order')->makePayment($log);

          return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
        }
      }

      return array(
        'form' => $form->createView(),
        'order' => $order,
      );
    }

    /**
     * @Route("/cash/{order_id}")
     * @Template()
     */
    public function indexAction($order_id)
    {
      $em = $this->getDoctrine()->getEntityManager();
      $order = $em->find('ClubShopBundle:Order', $order_id);

      return array(
        'order' => $order,
      );
    }
}
