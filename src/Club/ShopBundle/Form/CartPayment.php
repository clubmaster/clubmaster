<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CartPayment extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('payment_method', 'entity', array(
          'class' => 'Club\ShopBundle\Entity\PaymentMethod',
          'expanded' => true
      ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\Cart'
    ));
  }

  public function getName()
  {
    return 'cart_payment';
  }
}
