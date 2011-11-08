<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Team extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('team_name');
    $builder->add('description');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Team'
    );
  }

  public function getName()
  {
    return 'team';
  }
}
