<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaymentMethod extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('payment_method_name');
    $builder->add('priority');
    $builder->add('success_page');
    $builder->add('error_page');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\PaymentMethod'
    );
  }

  public function getName()
  {
    return 'payment_method';
  }
}
