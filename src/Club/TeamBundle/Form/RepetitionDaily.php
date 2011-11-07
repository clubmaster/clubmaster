<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RepetitionDaily extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('first_date');
    $builder->add('last_date');
    $builder->add('end_occurrences');
    $builder->add('repeat_every');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Repetition'
    );
  }

  public function getName()
  {
    return 'repetition_daily';
  }
}
