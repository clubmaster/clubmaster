<?php

namespace Club\Payment\QuickpayBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Quickpay extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('protocol','hidden');
    $builder->add('msgtype','hidden');
    $builder->add('merchant','hidden');
    $builder->add('language','hidden');
    $builder->add('ordernumber','hidden');
    $builder->add('amount','hidden');
    $builder->add('currency','hidden');
    $builder->add('continueurl','hidden');
    $builder->add('cancelurl','hidden');
    $builder->add('callbackurl','hidden');
    $builder->add('autocapture','hidden');
    $builder->add('autofee','hidden');
    $builder->add('cardtypelock','hidden');
    $builder->add('description','hidden');
    $builder->add('testmode','hidden');
    $builder->add('splitpayment','hidden');
    $builder->add('ipaddress','hidden');
    $builder->add('md5check','hidden');
  }

  public function getName()
  {
    return 'quickpay';
  }
}
