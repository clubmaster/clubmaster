<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfileCompany extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('company_name');
    $builder->add('cvr');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfileCompany'
    );
  }
}
