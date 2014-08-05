<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Rule extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $builder
            ->add('name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'Name of the rule'
            ))
            ->add('point_won', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'Points added for winning a match'
            ))
            ->add('point_lost', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'Points subtracted for losing a match'
            ))
            ->add('same_player', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'How many times you can play against the same player'
            ))
            ;
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
