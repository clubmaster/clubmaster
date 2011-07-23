<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RequestPassword extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('username', 'text',array(
      'required' => 'false'
    ));
    $builder->add('email', 'text',array(
      'required' => 'false'
    ));
  }

  public function getName()
  {
    return 'request_password';
  }
}
