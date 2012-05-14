<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Rule extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('point_won');
    $builder->add('point_lost');
    $builder->add('match_same_player');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\MatchBundle\Entity\Rule'
    );
  }

  public function getName()
  {
    return 'rule';
  }
}
