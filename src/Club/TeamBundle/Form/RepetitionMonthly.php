<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RepetitionMonthly extends AbstractType
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
    $builder->add('day_of_month');

    $range = array(
      '1' => 'First week',
      '2' => 'Second week',
      '3' => 'Third week',
      '4' => 'Fourth week',
      'last' => 'Last week'
    );
    $builder->add('week', 'choice', array(
      'choices' => $range
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
    return 'repetition_monthly';
  }
}
