<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DatabaseStep extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('host');
    $builder->add('port');
    $builder->add('dbname');
    $builder->add('user');
    $builder->add('password','repeated', array(
      'required' => false,
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password again'
    ));
  }
}
