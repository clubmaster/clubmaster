<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Shipping extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('shipping_name');
    $builder->add('description');
    $builder->add('price');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Shipping'
    );
  }

  public function getName()
  {
    return 'shipping';
  }
}
