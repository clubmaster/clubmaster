<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Coupon extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\Coupon'
    ));
  }

  public function getName()
  {
    return 'coupon';
  }
}
