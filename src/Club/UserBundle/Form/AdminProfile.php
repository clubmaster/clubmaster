<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminProfile extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('gender','choice',array(
      'choices' => array(
        'male' => 'Male',
        'female' => 'Female'
      )
    ));
    $builder->add('day_of_birth','birthday', array(
        'widget' => 'single_text'
    ));
    $builder->add('profile_address', new \Club\UserBundle\Form\AdminProfileAddress());
    $builder->add('profile_email', new \Club\UserBundle\Form\AdminProfileEmail());
    $builder->add('profile_phone', new \Club\UserBundle\Form\AdminProfilePhone());
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\Profile'
    ));
  }

  public function getName()
  {
    return 'admin_profile';
  }
}
