<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Product extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('product_name');
    $builder->add('description');
    $builder->add('price');
    $builder->add('vat');
    $builder->add('categories');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Product'
    );
  }
}
