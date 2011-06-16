<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Filter extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('attributes', 'collection', array(
      'type' => new \Club\UserBundle\Form\FilterAttribute()
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Filter'
    );
  }
}
