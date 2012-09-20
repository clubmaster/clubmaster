<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Ranking extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('name');
    $builder->add('rule');
    $builder->add('gender', 'gender', array(
      'required' => false
    ));
    $builder->add('invite_only', 'checkbox', array(
      'required' => false
    ));
    $builder->add('game_set', 'best_of_set');
    $builder->add('start_date', 'jquery_datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('end_date', 'jquery_datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\RankingBundle\Entity\Ranking'
    ));
  }

  public function getName()
  {
    return 'ranking';
  }
}
