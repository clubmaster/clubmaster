<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderStatus extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('status_name');
    $builder->add('paid','checkbox',array(
      'required' => false
    ));
    $builder->add('delivered','checkbox',array(
      'required' => false
    ));
    $builder->add('cancelled','checkbox',array(
      'required' => false
    ));
    $builder->add('priority');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\OrderStatus'
    ));
  }

  public function getName()
  {
    return 'order_status';
  }
}
