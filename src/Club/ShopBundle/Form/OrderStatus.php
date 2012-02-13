<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class OrderStatus extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('status_name');
    $builder->add('accepted','checkbox',array(
      'required' => false
    ));
    $builder->add('cancelled','checkbox',array(
      'required' => false
    ));
    $builder->add('priority');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\OrderStatus'
    );
  }

  public function getName()
  {
    return 'order_status';
  }
}
