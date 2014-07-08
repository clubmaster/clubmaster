<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class User extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('password', 'repeated', array(
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password_again',
      'required' => false
    ));
    $builder->add('profile', new \Club\UserBundle\Form\Profile());
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\User',
      'cascade_validation' => true,
      'validation_groups' => 'user'
    ));
  }

  public function getName()
  {
    return 'user';
  }
}
