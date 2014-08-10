<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepetitionMonthly extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $dailyRange = array();
        foreach (range(1,50) as $value) {
            $dailyRange[$value] = $value;
        }

        $weeklyRange = array(
            'first' => 'First week',
            'second' => 'Second week',
            'third' => 'Third week',
            'fourth' => 'Fourth week',
            'last' => 'Last week'
        );

        $builder
            ->add('first_date', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('last_date', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('end_occurrences', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('type', 'hidden')
            ->add('repeat_every', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $dailyRange
            ))
            ->add('day_of_month', 'checkbox', array(
                'required' => false
            ))
            ->add('week', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $weeklyRange,
                'required' => false
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\TeamBundle\Entity\Repetition'
        ));
    }

    public function getName()
    {
        return 'repetition_monthly';
    }
}
