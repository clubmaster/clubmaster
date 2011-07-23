<?php

namespace Club\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Account extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('account_name');
    $builder->add('account_number');
    $builder->add('account_type', 'choice', array(
      'choices' => array(
        'asset' => 'asset',
        'liability' => 'liability',
        'equity' => 'equity',
        'income' => 'income',
        'expense' => 'expense'
    )));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\AccountBundle\Entity\Account'
    );
  }

  public function getName()
  {
    return 'account';
  }
}
