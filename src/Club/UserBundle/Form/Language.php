<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Language extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('code');
    $builder->add('locale');
    $builder->add('charset');
    $builder->add('date_format_short');
    $builder->add('date_format_long');
    $builder->add('time_format');
    $builder->add('text_direction');
    $builder->add('numeric_separator_decimal');
    $builder->add('numeric_separator_thousands');
    $builder->add('currency');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Language'
    );
  }

  public function getName()
  {
    return 'language';
  }
}
