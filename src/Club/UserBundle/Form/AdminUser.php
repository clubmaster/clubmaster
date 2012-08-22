<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminUser extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\User'
    ));
  }

  public function getName()
  {
    return 'admin_user';
  }
}
