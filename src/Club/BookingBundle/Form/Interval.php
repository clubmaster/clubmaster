<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Interval extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('day');
    $builder->add('start_time');
    $builder->add('stop_time');
    $builder->add('field');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\BookingBundle\Entity\Interval'
    );
  }

  public function getName()
  {
    return 'interval';
  }
}
