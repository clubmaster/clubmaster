<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Currency extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('currency_name');
    $builder->add('code');
    $builder->add('symbol_left');
    $builder->add('symbol_right');
    $builder->add('decimal_places');
    $builder->add('value');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Currency'
    );
  }

  public function getName()
  {
    return 'currency';
  }
}
