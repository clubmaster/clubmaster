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
    $fields = array('msgtype','ordernumber','amount','currency','time','state','qpstat','qpstatmsg','chstat','chstatmsg','merchant','merchantemail','transaction','cardtype','cardnumber','md5check');
    // Loop through $fields array, check if key exists in $_POST array, if so collect the value
    $message = '-X POST -d "';
    while (list(,$k) = each($fields)) {
      if (isset($_POST[$k])) {
        $message .= "$k=".$_POST[$k]."&";
      }
    }
    $message = preg_replace('/&$/', '"', $message); 
    // Send an email with the data posted to your resultpage
    mail('hollo@hollo.dk', 'resultpage', $message);

    $r = $this->getRequest();

    $t = new \Club\Payment\QuickpayBundle\Entity\Transaction();
    $t->setMsgtype($r->get('msgtype'));
    $t->setOrdernumber($r->get('ordernumber'));
    $t->setAmount($r->get('amount'));
    $t->setCurrency($r->get('currency'));
    $t->setTime($r->get('time'));
    $t->setState($r->get('state'));
    $t->setQpstat($r->get('qpstat'));
    $t->setQpstatmsg($r->get('qpstatmsg'));
    $t->setChstat($r->get('chstat'));
    $t->setChstatmsg($r->get('chstatmsg'));
    $t->setMerchant($r->get('merchant'));
    $t->setMerchantemail($r->get('merchantemail'));
    $t->setTransaction($r->get('transaction'));
    $t->setCardtype($r->get('cardtype'));
    $t->setCardnumber($r->get('cardnumber'));
    $t->setCardexpire($r->get('cardexpire'));
    $t->setSplitpayment($r->get('splitpayment'));
    $t->setFraudprobability($r->get('fraudprobability'));
    $t->setFraudremarks($r->get('fraudremarks'));
    $t->setFee($r->get('fee'));
    $t->setMd5check($r->get('md5check'));

    $em = $this->getDoctrine()->getEntityManager();
    $em->persist($t);
    $em->flush();

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
      //$res['autofee'].
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
}
