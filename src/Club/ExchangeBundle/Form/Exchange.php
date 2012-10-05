<?php

namespace Club\ExchangeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Exchange extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('play_time', 'jquery_datetime', array(
      'date_widget' => 'single_text',
      'time_widget' => 'single_text',
    ));
    $builder->add('message', 'textarea', array(
        'attr' => array(
            'class' => 'big'
        )
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ExchangeBundle\Entity\Exchange'
    ));
  }

  public function getName()
  {
    return 'exchange';
  }
}
