<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminProfileEmail extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $types = array(
      'home' => 'Home',
      'business' => 'Business'
    );
    $builder->add('contact_type', 'choice', array(
      'choices' => $types
    ));
    $builder->add('email_address');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfileEmail'
    );
  }

  public function getName()
  {
    return 'admin_profile_email';
  }
}
