<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Plan extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('description');
    $builder->add('first_date');
    $builder->add('end_date');
    $builder->add('fields');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\BookingBundle\Entity\Plan'
    );
  }

  public function getName()
  {
    return 'admin_field';
  }
}
