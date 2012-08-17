<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminUser extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('password', 'repeated', array(
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password_again',
      'required' => false
    ));
    $builder->add('member_number','text');
    $builder->add('profile', new \Club\UserBundle\Form\AdminProfile());
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }

  public function getName()
  {
    return 'admin_user';
  }
}
