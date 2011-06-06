<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ForgotPassword extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('password', 'repeated');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }
}
