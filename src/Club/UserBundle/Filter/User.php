<?php

namespace Club\UserBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class User extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('member_number','text',array(
      'required' => false
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }
}
