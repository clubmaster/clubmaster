<?php

namespace Club\Payment\QuickpayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class QuickpayController extends Controller
{
  /**
   * @Route("/quickpay/success/{order_id}")
   * @Template()
   */
  public function successAction()
  {
    return array();
  }

  /**
   * @Route("/quickpay/cancel/{order_id}")
   * @Template()
   */
  public function cancelAction()
  {
    return array();
  }

  /**
   * @Route("/quickpay/callback/{order_id}")
   * @Template()
   * @Method("POST")
   */
  public function callbackAction($order_id)
  {
    $r = $this->getRequest();
    $accepted = false;

    if ($r->get('qpstat') == '000')
      $accepted = $this->validateTransaction();

    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order', $order_id);

    $t = new \Club\ShopBundle\Entity\PurchaseLog();
    $t->setAmount($r->get('amount'));
    $t->setCurrency($r->get('currency'));
    $t->setMerchant($r->get('merchant'));
    $t->setTransaction($r->get('transaction'));
    $t->setCardtype($r->get('cardtype'));
    $t->setOrder($order);
    $t->setAccepted($accepted);
    $t->setResponse(json_encode($this->getRequest()->request->all()));

    $payment = $em->getRepository('ClubShopBundle:PaymentMethod')->findOneBy(array(
      'controller' => $this->container->getParameter('club_payment_quickpay.controller')
    ));
    $t->setPaymentMethod($payment);

    $em->persist($t);
    $em->flush();

    if ($accepted) {
      $this->get('order')->setOrder($order);
      $this->get('order')->makePayment($t);
    }

    return new Response('OK');
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
      'quickpay_url' => $this->container->getParameter('club_payment_quickpay.quickpay_url'),
      'form' => $form->createView(),
      'order' => $order
    );
  }

  protected function getForm(\Club\ShopBundle\Entity\Order $order)
  {
    $res = array(
      'msgtype' => 'authorize',
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
      'ipaddress' => $this->getRequest()->getClientIP()
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
      $res['ipaddress'].
      $res['testmode'].
      $res['splitpayment'].
      $this->container->getParameter('club_payment_quickpay.secret')
    );
    $res['md5check'] = $md5check;

    $form = $this->createForm(new \Club\Payment\QuickpayBundle\Form\Quickpay, $res);

    return $form;
  }

  protected function validateTransaction()
  {
    $r = $this->getRequest();

    $md5check = md5(
      $r->get('msgtype').
      $r->get('ordernumber').
      $r->get('amount').
      $r->get('currency').
      $r->get('time').
      $r->get('state').
      $r->get('qpstat').
      $r->get('qpstatmsg').
      $r->get('chstat').
      $r->get('chstatmsg').
      $r->get('merchant').
      $r->get('merchantemail').
      $r->get('transaction').
      $r->get('cardtype').
      $r->get('cardnumber').
      $r->get('cardexpire').
      $r->get('splitpayment').
      $r->get('fraudprobability').
      $r->get('fraudremarks').
      $r->get('fraudreport').
      $r->get('fee').
      $this->container->getParameter('club_payment_quickpay.secret')
    );

    return ($md5check == $r->get('md5check')) ? true : false;
  }
}
