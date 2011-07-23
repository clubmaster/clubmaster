<?php

namespace Club\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Ledger extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('account');
    $builder->add('user');
    $builder->add('value');
    $builder->add('note');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\AccountBundle\Entity\Ledger'
    );
  }

  public function getName()
  {
    return 'ledger';
  }
}
