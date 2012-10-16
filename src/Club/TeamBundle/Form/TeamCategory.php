<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamCategory extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('team_name');
    $builder->add('description', 'textarea', array(
        'attr' => array(
            'class' => 'big'
        )
    ));
    $builder->add('penalty');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\TeamBundle\Entity\TeamCategory'
    ));
  }

  public function getName()
  {
    return 'team_category';
  }
}
