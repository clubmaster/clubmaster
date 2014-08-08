<?php

namespace Club\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Ranking extends AbstractType
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
                'label_attr' => $label_attr
            ))
            ->add('rule', 'entity', array(
                'class' => 'ClubRankingBundle:Rule',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('gender', 'gender', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('invite_only', 'checkbox', array(
                'required' => false
            ))
            ->add('game_set', 'best_of_set', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('start_date', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'time_widget' => 'single_text'
            ))
            ->add('end_date', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'time_widget' => 'single_text'
            ))
            ;
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
