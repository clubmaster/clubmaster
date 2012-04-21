<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('order_products', 'collection', array(
      'type' => new OrderProduct()
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Order'
    );
  }

  public function getName()
  {
    return 'order';
  }
}
