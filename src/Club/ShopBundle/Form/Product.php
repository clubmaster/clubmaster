<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Product extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('product_name');
    $builder->add('description');
    $builder->add('price');
    $builder->add('quantity', 'integer', array(
        'help' => 'Amount in stock, -1 if unlimited'
    ));
    $builder->add('categories');
    $builder->add('account_number', 'text', array(
        'required' => false,
        'help' => 'Account number in accounting program'
    ));
    $builder->add('active', 'checkbox', array(
        'required' => false
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\Product'
    ));
  }

  public function getName()
  {
    return 'product';
  }
}
