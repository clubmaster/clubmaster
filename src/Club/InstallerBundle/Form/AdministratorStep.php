<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdministratorStep extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('email_address');
    $builder->add('password','repeated', array(
      'required' => false,
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password again'
    ));
  }
}
