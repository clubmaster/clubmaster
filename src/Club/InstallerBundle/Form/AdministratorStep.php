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
      'second_name' => 'Password_again'
    ));
    $builder->add('profile', new \Club\InstallerBundle\Form\AdministratorProfile());
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }

  public function getName()
  {
    return 'administrator_step';
  }
}
