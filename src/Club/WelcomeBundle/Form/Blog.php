<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Blog extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('title');
    $builder->add('message');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\WelcomeBundle\Entity\Blog'
    );
  }

  public function getName()
  {
    return 'blog';
  }
}
