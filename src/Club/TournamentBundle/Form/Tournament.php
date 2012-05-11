<?php

namespace Club\TournamentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Tournament extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('description');
    $builder->add('min_attend');
    $builder->add('max_attend');
    $builder->add('seeds');
    $builder->add('start_time');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TournamentBundle\Entity\Tournament'
    );
  }

  public function getName()
  {
    return 'tournament';
  }
}
