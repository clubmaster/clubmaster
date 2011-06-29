<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdministratorStep extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('password','repeated', array(
      'required' => true,
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password again'
    ));
    $builder->add('language');
    $builder->add('profile',new \Club\InstallerBundle\Form\AdministratorProfile());
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }
}
