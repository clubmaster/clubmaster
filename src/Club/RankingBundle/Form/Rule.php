<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Rule extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('point_won');
    $builder->add('point_loss');
    $builder->add('match_same_player');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\RankingBundle\Entity\Rule'
    );
  }

  public function getName()
  {
    return 'rule';
  }
}
