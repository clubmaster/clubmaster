<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Category extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('category_name');
    $builder->add('description');
    $builder->add('category');
    $builder->add('location');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Category'
    );
  }
}
