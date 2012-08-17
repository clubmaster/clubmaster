<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Location extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('location_name');
    $builder->add('club');
    $builder->add('street');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('state');
    $builder->add('country', 'country');
    $builder->add('location','entity', array(
      'class' => 'Club\UserBundle\Entity\Location',
      'required' => false
    ));
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Location'
    );
  }

  public function getName()
  {
    return 'location';
  }
}
