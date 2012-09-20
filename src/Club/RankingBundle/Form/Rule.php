<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Rule extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('name');
    $builder->add('point_won');
    $builder->add('point_lost');
    $builder->add('same_player');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'Club\RankingBundle\Entity\Rule'
      ));
  }

  public function getName()
  {
    return 'rule';
  }
}
