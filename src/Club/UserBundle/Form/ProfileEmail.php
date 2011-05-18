<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfileEmail extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('email_address');
    $builder->add('contact_type','choice',array(
      'choices' => array(
        'home' => 'Home',
        'work' => 'Work'
      )
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfileEmail'
    );
  }
}
