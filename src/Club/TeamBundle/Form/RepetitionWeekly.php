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
    $builder->add('repeat_every');
    $builder->add('days_in_week');
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
