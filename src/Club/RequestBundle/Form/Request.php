<?php

namespace Club\RequestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Request extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('play_time');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\RequestBundle\Entity\Request'
    );
  }

  public function getName()
  {
    return 'request';
  }
}
