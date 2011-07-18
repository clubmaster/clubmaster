<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Coupon extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $arr = array();
    for ($i = 1; $i < 50; $i++) {
      $arr[$i] = $i;
    }

    $builder->add('coupon_key');
    $builder->add('value');
    $builder->add('max_usage','choice',array(
      'choices' => $arr
    ));
    $builder->add('expire_at');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Coupon'
    );
  }
}
