<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Game extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('rule');
    $builder->add('locked', 'checkbox', array(
      'required' => false
    ));
    $builder->add('invite_only', 'checkbox', array(
      'required' => false
    ));
    $builder->add('game_set');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\RankingBundle\Entity\Game'
    );
  }

  public function getName()
  {
    return 'game';
  }
}
