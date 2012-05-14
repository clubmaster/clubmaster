<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Welcome extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('content');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\WelcomeBundle\Entity\Welcome'
    );
  }

  public function getName()
  {
    return 'welcome';
  }
}
