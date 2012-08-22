<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepetitionYearly extends AbstractType
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
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\TeamBundle\Entity\Repetition'
    ));
  }

  public function getName()
  {
    return 'repetition_yearly';
  }
}
