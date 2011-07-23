<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CheckoutShipping extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('shipping');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Cart'
    );
  }

  public function getName()
  {
    return 'checkout_shipping';
  }
}
