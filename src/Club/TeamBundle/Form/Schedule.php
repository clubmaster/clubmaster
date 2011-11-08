<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Schedule extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('description');
    $builder->add('first_date');
    $builder->add('end_date');
    $builder->add('level');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Schedule'
    );
  }

  public function getName()
  {
    return 'schedule';
  }
}
