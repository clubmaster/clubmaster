<?php

namespace Club\Payment\QuickpayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class QuickpayController extends Controller
{
  /**
   * @Route("/quickpay/success/{order_id}")
   * @Template()
   */
  public function successAction()
  {
  }

  /**
   * @Route("/quickpay/cancel/{order_id}")
   * @Template()
   */
  public function cancelAction()
  {
  }

  /**
   * @Route("/quickpay/callback/{order_id}")
   * @Template()
   */
  public function callbackAction($order_id)
  {
  }

  /**
   * @Route("/quickpay/{order_id}")
   * @Template()
   */
  public function indexAction($order_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order', $order_id);

    $form = $this->getForm($order);
    return array(
      'quickpay_url' => $this->container->getParameter('quickpay_url'),
      'form' => $form->createView(),
      'order' => $order
    );
  }

  protected function getForm(\Club\ShopBundle\Entity\Order $order)
  {
      //'secret' => $this->container->getParameter('club_payment_quickpay.secret'),

    $res = array(
      'msgtype' => 'capture',
      'ordernumber' => $order->getOrderNumber(),
      'amount' => ($order->getPrice()*100),
      'continueurl' => $this->generateUrl('club_payment_quickpay_quickpay_success', array(
        'order_id' => $order->getId()
      ), true),
      'cancelurl' => $this->generateUrl('club_payment_quickpay_quickpay_cancel', array(
        'order_id' => $order->getId()
      ),true),
      'callbackurl' => $this->generateUrl('club_payment_quickpay_quickpay_callback', array(
        'order_id' => $order->getId()
      ), true),
      'protocol' => $this->container->getParameter('club_payment_quickpay.protocol'),
      'merchant' => $this->container->getParameter('club_payment_quickpay.merchant'),
      'language' => $this->container->getParameter('club_payment_quickpay.language'),
      'currency' => $this->container->getParameter('club_payment_quickpay.currency'),
      'autocapture' => $this->container->getParameter('club_payment_quickpay.autocapture'),
      'autofee' => $this->container->getParameter('club_payment_quickpay.autofee'),
      'cardtypelock' => $this->container->getParameter('club_payment_quickpay.cardtypelock'),
      'testmode' => $this->container->getParameter('club_payment_quickpay.testmode'),
      'splitpayment' => $this->container->getParameter('club_payment_quickpay.splitpayment'),
    );

    $md5check = md5(
      $res['protocol'].
      $res['msgtype'].
      $res['merchant'].
      $res['language'].
      $res['ordernumber'].
      $res['amount'].
      $res['currency'].
      $res['continueurl'].
      $res['cancelurl'].
      $res['callbackurl'].
      $res['autocapture'].
      $res['autofee'].
      $res['cardtypelock'].
      $res['testmode'].
      $res['splitpayment'].
      $this->container->getParameter('club_payment_quickpay.secret')
    );
    $res['md5check'] = $md5check;

    $form = $this->createForm(new \Club\Payment\QuickpayBundle\Form\Quickpay, $res);

    return $form;
  }
}
