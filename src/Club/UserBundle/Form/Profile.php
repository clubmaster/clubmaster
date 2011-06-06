<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Profile extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('gender','choice',array(
      'choices' => array(
        'male' => 'Male',
        'female' => 'Female'
      )
    ));
    $builder->add('day_of_birth');
    $builder->add('profile_address','collection', array(
      'type' => new \Club\UserBundle\Form\ProfileAddress()
    ));
    $builder->add('profile_phone','collection', array(
      'type' => new \Club\UserBundle\Form\ProfilePhone()
    ));
    $builder->add('profile_email','collection', array(
      'type' => new \Club\UserBundle\Form\ProfileEmail()
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Profile'
    );
  }
}
