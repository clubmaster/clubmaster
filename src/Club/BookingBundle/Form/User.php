<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class User extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('id', 'hidden');
    $builder->add('query', 'text', array(
      'label' => 'Partner'
    ));
  }

  public function getName()
  {
    return 'booking';
  }
}
