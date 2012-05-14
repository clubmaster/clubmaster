<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class OrderProduct extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('quantity');
    $builder->add('price');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\OrderProduct'
    );
  }

  public function getName()
  {
    return 'order_product';
  }
}
