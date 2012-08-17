<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminProfilePhone extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('phone_number');
  }

  public function getDefaultOptions()
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
