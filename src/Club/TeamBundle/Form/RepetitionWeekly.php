<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepetitionWeekly extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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
    $range = array(
      1 => 'Monday',
      2 => 'Tuesday',
      3 => 'Wednesday',
      4 => 'Thursday',
      5 => 'Friday',
      6 => 'Saturday',
      7 => 'Sunday'
    );
    $builder->add('days_in_week', 'choice', array(
      'choices' => $range,
      'multiple' => true
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\TeamBundle\Entity\Repetition'
    ));
  }

  public function getName()
  {
    return 'repetition_weekly';
  }
}
