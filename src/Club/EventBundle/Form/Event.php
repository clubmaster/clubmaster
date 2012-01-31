<?php

namespace Club\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Event extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('event_name');
    $builder->add('description');
    $builder->add('max_attends');
    $builder->add('start_date');
    $builder->add('stop_date');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\EventBundle\Entity\Event'
    );
  }

  public function getName()
  {
    return 'event';
  }
}
