<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminProfilePhone extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $types = array(
      'home' => 'Home',
      'business' => 'Business',
      'mobile' => 'Mobile'
    );
    $builder->add('contact_type', 'choice', array(
      'choices' => $types
    ));
    $builder->add('phone_number');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfilePhone'
    );
  }

  public function getName()
  {
    return 'admin_profile_phone';
  }
}
