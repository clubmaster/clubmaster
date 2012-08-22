<?php

namespace Club\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Event extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('event_name');
    $builder->add('description');
    $builder->add('max_attends');
    $builder->add('start_date');
    $builder->add('stop_date');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\EventBundle\Entity\Event'
    ));
  }

  public function getName()
  {
    return 'event';
  }
}
