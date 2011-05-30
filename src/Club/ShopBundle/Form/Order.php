<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Order extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('order_status');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Order'
    );
  }
}
