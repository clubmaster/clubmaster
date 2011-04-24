<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\ChoiceField;

class CheckoutPaymentForm extends Form
{
  public function configure()
  {
    $this->addOption('em');
    $em = $this->getOption('em');

    $payments = $em->getRepository('Club\ShopBundle\Entity\PaymentMethod')->findAll();

    $res = array();
    foreach ($payments as $payment) {
      $res[$payment->getId()] = $payment->getPaymentMethodName();
    }
    $this->add(new ChoiceField('payment',array(
      'choices' => $res,
      'expanded' => true,
      'multiple' => false,
    )));
  }
}
?>
