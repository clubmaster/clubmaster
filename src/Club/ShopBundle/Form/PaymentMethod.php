<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentMethod extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('payment_method_name');
    $builder->add('priority');
    $builder->add('success_page', 'tinymce');
    $builder->add('error_page', 'tinymce');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\PaymentMethod'
    ));
  }

  public function getName()
  {
    return 'payment_method';
  }
}
