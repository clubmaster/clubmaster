<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminProfilePhone extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('number','text',array(
      'required' => false
    ));
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
