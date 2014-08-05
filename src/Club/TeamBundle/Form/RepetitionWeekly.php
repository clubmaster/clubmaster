<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepetitionWeekly extends AbstractType
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
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        );

        $builder
            ->add('first_date', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('last_date', 'jquery_datetime', array(
                'attr' => $attr,
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
            ->add('days_in_week', 'choice', array(
                'attr' => array(
                    'class' => 'form-control',
                    'size' => 7
                ),
                'label_attr' => $label_attr,
                'choices' => $weeklyRange,
                'multiple' => true
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
        return 'repetition_weekly';
    }
}
