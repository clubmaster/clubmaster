<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Level extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('level_name');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Level'
    );
  }

  public function getName()
  {
    return 'level';
  }
}
