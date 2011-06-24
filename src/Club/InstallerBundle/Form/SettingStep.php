<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SettingStep extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('location');
    $builder->add('language');
    $builder->add('currency');
    $builder->add('smtp_host');
    $builder->add('smtp_port');
    $builder->add('smtp_username');
    $builder->add('smtp_password','repeated', array(
      'required' => false,
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password again'
    ));
  }
}
