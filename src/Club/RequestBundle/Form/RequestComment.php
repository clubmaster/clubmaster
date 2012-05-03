<?php

namespace Club\RequestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RequestComment extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('comment');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\RequestBundle\Entity\RequestComment'
    );
  }

  public function getName()
  {
    return 'request_comment';
  }
}
