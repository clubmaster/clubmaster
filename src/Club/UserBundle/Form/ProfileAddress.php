<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfileAddress extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('street');
    $builder->add('suburl');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('state');
    $builder->add('country');
    $builder->add('contact_type','choice',array(
      'choices' => array(
        'home' => 'Home',
        'work' => 'Work'
      )
    ));
    $builder->add('is_default','hidden');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfileAddress'
    );
  }
}
