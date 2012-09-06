<?php

namespace Club\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Ticker extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('message');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\NewsBundle\Entity\Ticker'
    );
  }

  public function getName()
  {
    return 'ticker';
  }
}
