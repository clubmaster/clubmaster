<?php

namespace Club\MessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MessageAttachment extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('file');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\MessageBundle\Entity\MessageAttachment'
    );
  }

  public function getName()
  {
    return 'message_attachment';
  }
}
