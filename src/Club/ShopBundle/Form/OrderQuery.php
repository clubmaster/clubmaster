<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderQuery extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('query', 'text');
  }

  public function getName()
  {
    return 'query';
  }
}
