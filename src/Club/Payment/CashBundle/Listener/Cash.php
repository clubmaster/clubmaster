<?php

namespace Club\Payment\CashBundle\Listener;

class Cash
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onPaymentMethodGet(\Club\ShopBundle\Event\FilterPaymentMethodEvent $event)
  {
    $name = 'Cash';
    $controller = 'club_payment_cash_cash_index';

    $method = $this->em->getRepository('ClubShopBundle:PaymentMethod')->findOneBy(array(
      'controller' => $controller
    ));

    if (!$method) {
      $method = new \Club\ShopBundle\Entity\PaymentMethod();
      $method->setPaymentMethodName($name);
      $method->setController($controller);
      $method->setSuccessPage(<<<EOF
<h2>Thank you</h2>
<p>Your order has been successful completed.</p>
<p>We will complete your order as soon as we receive the payment.</p>
EOF
);
      $method->setErrorPage(<<<EOF
<h2>Sorry</h2>
  <p>Your order has not been completed.</p>
  <p>There was a problem with the payment.</p>
EOF
);

      $this->em->persist($method);
      $this->em->flush();
    }

    $event->setMethod($method);
  }
}
