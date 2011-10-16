<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Vat extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('vat_name');
    $builder->add('rate');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Vat'
    );
  }

  public function getName()
  {
    return 'vat';
  }
}
