<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class ProductAttribute extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $res = range(1,100);
    $tickets = array();
    foreach ($res as $i) {
      $tickets[$i] = $i;
    }
    $res = range(1,10);
    $pauses = array();
    foreach ($res as $i) {
      $pauses[$i] = $i;
    }

    $bool = array(
      1 => 'Yes'
    );

    $renewal = array(
      'A' => 'After expire',
      'Y' => 'Yearly',
    );

    $builder->add('time_interval', 'text', array(
      'required' => false
    ));
    $builder->add('ticket', 'choice', array(
      'required' => false,
      'choices' => $tickets
    ));
    $builder->add('auto_renewal', 'choice', array(
      'required' => false,
      'choices' => $renewal,
      'label' => 'Auto Renewal'
    ));
    $builder->add('allowed_pauses', 'choice', array(
      'required' => false,
      'choices' => $pauses,
      'label' => 'Allowed Pauses'
    ));
    $builder->add('booking', 'choice', array(
      'required' => false,
      'choices' => $bool,
      'label' => 'Use booking'
    ));
    $builder->add('team', 'choice', array(
      'required' => false,
      'choices' => $bool,
      'label' => 'Use team'
    ));
    $builder->add('start_date', 'date', array(
      'required' => false,
      'label' => 'Start date'
    ));
    $builder->add('expire_date', 'date', array(
      'required' => false,
      'label' => 'Expire date'
    ));
    $builder->add('location','entity',array(
      'class' => 'Club\UserBundle\Entity\Location',
      'multiple' => true,
      'required' => false
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Model\Attribute'
    );
  }

  public function getName()
  {
    return 'product_attribute';
  }
}
