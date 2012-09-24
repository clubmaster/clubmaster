<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Rule extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'help' => 'Name of the rule'
        ));
        $builder->add('point_won', 'integer', array(
            'help' => 'Points added for winning a match'
        ));
        $builder->add('point_lost', 'integer', array(
            'help' => 'Points subtracted for losing a match'
        ));
        $builder->add('same_player', 'integer', array(
            'help' => 'How many times you can play against the same player'
        ));
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
