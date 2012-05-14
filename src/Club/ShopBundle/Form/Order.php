<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Order extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('order_status', 'entity', array(
      'class' => 'Club\ShopBundle\Entity\OrderStatus',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('os')
          ->orderBy('os.priority', 'ASC');
      }
    ));
    $builder->add('note');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Order'
    );
  }

  public function getName()
  {
    return 'order';
  }
}
