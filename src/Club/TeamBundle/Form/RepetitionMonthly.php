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

    $range = array();
    foreach (range(1,50) as $value) {
      $range[$value] = $value;
    }
    $builder->add('repeat_every', 'choice', array(
      'choices' => $range
    ));
    $builder->add('day_of_month');

    $range = array(
      'first' => 'First week',
      'second' => 'Second week',
      'third' => 'Third week',
      'fourth' => 'Fourth week',
      'last' => 'Last week'
    );
    $builder->add('week', 'choice', array(
      'choices' => $range,
      'required' => false
    ));
  }

  public function getDefaultOptions()
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
