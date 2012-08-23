<?php

namespace Club\RequestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Request extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('play_time', 'datetime', array(
          'date_widget' => 'single_text',
          'time_widget' => 'single_text'
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\RequestBundle\Entity\Request'
    ));
  }

  public function getName()
  {
    return 'request';
  }
}
