<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserNote extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('note');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\UserNote'
    );
  }

  public function getName()
  {
    return 'user_note';
  }
}
