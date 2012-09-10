<?php

namespace Club\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Club\LayoutBundle\Form\TinyMceType;
use Club\LayoutBundle\Form\JQueryDateTimeType;

class Event extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('event_name');
    $builder->add('description', new TinyMceType());
    $builder->add('max_attends');
    $builder->add('start_date', new JQueryDateTimeType(), array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('stop_date', new JQueryDateTimeType(), array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
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
