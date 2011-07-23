<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductAttribute extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('attribute');
    $builder->add('value');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\ProductAttribute'
    );
  }

  public function getName()
  {
    return 'product_attribute';
  }
}
