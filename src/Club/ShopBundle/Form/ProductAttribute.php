<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductAttribute extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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
    $builder->add('start_time', 'time', array(
      'required' => false,
      'label' => 'Start time'
    ));
    $builder->add('stop_time', 'time', array(
      'required' => false,
      'label' => 'Stop time'
    ));
    $builder->add('start_date', 'jquery_date', array(
        'widget' => 'single_text',
        'required' => false,
        'label' => 'Start date'
    ));
    $builder->add('expire_date', 'jquery_date', array(
        'widget' => 'single_text',
        'required' => false,
        'label' => 'Expire date'
    ));
    $builder->add('location','entity',array(
      'class' => 'Club\UserBundle\Entity\Location',
      'multiple' => true,
      'required' => false
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Model\Attribute'
    ));
  }

  public function getName()
  {
    return 'product_attribute';
  }
}
