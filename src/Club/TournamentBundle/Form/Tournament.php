<?php

namespace Club\TournamentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Tournament extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $set = array(
      1 => 1,
      3 => 3,
      5 => 5
    );

    $builder->add('name');
    $builder->add('description');
    $builder->add('game_set', 'choice', array(
      'choices' => $set
    ));
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
