<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RepetitionWeekly extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('first_date');
    $builder->add('last_date');
    $builder->add('end_occurrences');
    $builder->add('type', 'hidden');
    $range = range(1,50);
    $builder->add('repeat_every', 'choice', array(
      'choices' => $range
    ));
    $range = array(
      'monday' => 'Monday',
      'tuesday' => 'Tuesday',
      'wednesday' => 'Wednesday',
      'thursday' => 'Thursday',
      'friday' => 'Friday',
      'saturday' => 'Saturday',
      'sunday' => 'Sunday'
    );
    $builder->add('days_in_week', 'choice', array(
      'choices' => $range,
      'multiple' => true
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Repetition'
    );
  }

  public function getName()
  {
    return 'repetition_weekly';
  }
}
