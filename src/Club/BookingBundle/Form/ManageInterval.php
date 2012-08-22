<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManageInterval extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $range = range(0,160);

    $builder->add('interval', 'choice', array(
      'choices' => $range
    ));
    $builder->add('start', 'time');
    $builder->add('stop', 'time');
  }

  public function getName()
  {
    return 'manage_interval';
  }
}
