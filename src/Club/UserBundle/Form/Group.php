<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Group extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $bool = array(
      '0' => 'No',
      '1' => 'Yes'
    );
    $builder->add('group_name');
    $builder->add('group_type','choice',array(
      'choices' => array(
        'static' => 'Static',
        'dynamic' => 'Dynamic'
      )
    ));
    $builder->add('is_active_member','choice',array(
      'choices' => $bool,
      'required' => false
    ));
    $builder->add('min_age');
    $builder->add('max_age');
    $builder->add('gender','choice',array(
      'choices' => array(
        'male' => 'Male',
        'female' => 'Female'
      ),
      'required' => false
    ));
    $builder->add('location');
    $builder->add('role');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Group'
    );
  }

  public function getName()
  {
    return 'group';
  }
}
