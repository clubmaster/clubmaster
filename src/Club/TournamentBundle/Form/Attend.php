<?php

namespace Club\TournamentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Attend extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('seed');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TournamentBundle\Entity\Attend'
    );
  }

  public function getName()
  {
    return 'attend';
  }
}
