<?php

namespace Club\MessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Message extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $type = array(
      'mail' => 'Mail'
    );

    $builder->add('locations');
    $builder->add('groups');
    $builder->add('users');
    $builder->add('events');
    $builder->add('type','choice',array(
      'choices' => $type
    ));
    $builder->add('subject');
    $builder->add('message');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\MessageBundle\Entity\Message'
    );
  }

  public function getName()
  {
    return 'message';
  }
}
