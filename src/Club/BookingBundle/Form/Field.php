<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Field extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('information');
    $builder->add('open');
    $builder->add('close');
    $builder->add('location');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\BookingBundle\Entity\Field'
    );
  }

  public function getName()
  {
    return 'admin_field';
  }
}
