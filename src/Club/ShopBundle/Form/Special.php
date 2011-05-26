<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Special extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('product');
    $builder->add('price');
    $builder->add('start_date');
    $builder->add('expire_date');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Special'
    );
  }
}
