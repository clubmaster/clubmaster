<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Club\LayoutBundle\Form\JQueryDateTimeType;

class RepetitionMonthly extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('first_date', new JQueryDateTimeType(), array(
          'date_widget' => 'single_text',
          'time_widget' => 'single_text'
      ));
      $builder->add('last_date', new JQueryDateTimeType(), array(
          'date_widget' => 'single_text',
          'time_widget' => 'single_text'
      ));
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\TeamBundle\Entity\Repetition'
    ));
  }

  public function getName()
  {
    return 'repetition_monthly';
  }
}
