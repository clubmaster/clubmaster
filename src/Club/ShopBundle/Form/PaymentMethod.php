<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaymentMethod extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('payment_method_name');
    $builder->add('page');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\PaymentMethod'
    );
  }
}
