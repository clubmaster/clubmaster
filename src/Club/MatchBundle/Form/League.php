<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class League extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $set = array(
      1 => 1,
      3 => 3,
      5 => 5
    );
    $builder->add('name');
    $builder->add('rule');
    $builder->add('gender', 'choice', array(
      'choices' => \Club\UserBundle\Helper\Util::getGenders(),
      'required' => false
    ));
    $builder->add('invite_only', 'checkbox', array(
      'required' => false
    ));
    $builder->add('game_set', 'choice', array(
      'choices' => $set
    ));
    $builder->add('start_date');
    $builder->add('end_date');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\MatchBundle\Entity\League'
    );
  }

  public function getName()
  {
    return 'league';
  }
}
