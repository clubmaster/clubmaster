<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPaymentMethodData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $payment = new \Club\ShopBundle\Entity\PaymentMethod();
    $payment->setPaymentMethodName('Cash');
    $payment->setPage('<h2>Thank you</h2><p>Your order has been successful completed.</p><p>We will complete your order as soon as we receive the payment.</p>');

    $manager->persist($payment);
    $manager->flush();
  }
}
