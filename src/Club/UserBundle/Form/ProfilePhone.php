<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfilePhone extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('number');
    $builder->add('contact_type','choice',array(
      'choices' => array(
        'home' => 'Home',
        'work' => 'Work',
        'mobile' => 'Mobile'
      )
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfilePhone'
    );
  }
}
