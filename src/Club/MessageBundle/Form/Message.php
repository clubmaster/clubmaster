<?php

namespace Club\MessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Message extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('sender_name');
    $builder->add('sender_address');
    $builder->add('groups');
    $builder->add('events');
    $builder->add('filters');
    $builder->add('users');
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
