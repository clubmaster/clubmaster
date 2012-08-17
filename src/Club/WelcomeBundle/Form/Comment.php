<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Comment extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('comment');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\WelcomeBundle\Entity\Comment'
    );
  }

  public function getName()
  {
    return 'comment';
  }
}
