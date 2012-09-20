<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatchComment extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('comment', 'textarea', array(
        'attr' => array(
            'class' => 'big'
        )
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\MatchBundle\Entity\MatchComment'
    ));
  }

  public function getName()
  {
    return 'match_comment';
  }
}
