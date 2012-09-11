<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class League extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $set = array(
      1 => 1,
      3 => 3,
      5 => 5
    );
    $builder->add('name');
    $builder->add('rule');
    $builder->add('gender', 'choice', array(
      'choices' => \Club\UserBundle\Helper\Util::getGenders(),
      'required' => false
    ));
    $builder->add('invite_only', 'checkbox', array(
      'required' => false
    ));
    $builder->add('game_set', 'choice', array(
      'choices' => $set
    ));
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
      'data_class' => 'Club\MatchBundle\Entity\League'
    ));
  }

  public function getName()
  {
    return 'league';
  }
}
