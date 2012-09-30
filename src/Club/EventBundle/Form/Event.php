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
    $builder->add('description', 'tinymce');
    $builder->add('max_attends');
    $builder->add('start_date', 'jquery_datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('stop_date', 'jquery_datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('last_subscribe', 'jquery_datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('street');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('country', 'country');
    $builder->add('public', 'checkbox',  array(
        'help' => 'If the event should be visible for guests.'
    ));
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
