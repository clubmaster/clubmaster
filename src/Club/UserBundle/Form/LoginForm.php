<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LoginForm extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('username','text');
    $builder->add('password','password');
  }
}
