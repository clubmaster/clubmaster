<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Order extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\Order'
    ));
  }

  public function getName()
  {
    return 'order';
  }
}
