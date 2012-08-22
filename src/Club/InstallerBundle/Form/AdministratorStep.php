<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministratorStep extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('password','repeated', array(
      'required' => true,
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password_again'
    ));
    $builder->add('profile', new \Club\InstallerBundle\Form\AdministratorProfile());
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\User'
    ));
  }

  public function getName()
  {
    return 'administrator_step';
  }
}
