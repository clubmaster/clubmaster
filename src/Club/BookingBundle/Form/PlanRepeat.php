<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanRepeat extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $repeats = array(
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly'
        );

        $repeat_by = array(
            'day_of_the_month' => 'Day of the month',
            'day_of_the_week' => 'Day of the week'
        );

        $ends_type = array(
            'never' => 'Ends never',
            'after' => 'Ends after',
            'on' => 'Ends on'
        );

        $repeat_every = array();
        for ($i = 1; $i <= 30; $i++) {
            $repeat_every[$i] = $i;
        }

        $builder
            ->add('repeats', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $repeats
            ))
            ->add('repeat_on', 'day', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'multiple' => 'true',
                'required' => false,
                'attr' => array(
                    'size' => 7
                )
            ))
            ->add('repeat_on_hour', 'hour', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'multiple' => 'true',
                'required' => false,
                'attr' => array(
                    'size' => 10
                )
            ))
            ->add('repeat_by', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $repeat_by
            ))
            ->add('repeat_every', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $repeat_every
            ))
            ->add('starts_on', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('ends_type', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $ends_type
            ))
            ->add('ends_after', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('ends_on', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text',
                'required' => false
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\BookingBundle\Entity\PlanRepeat'
        ));
    }

    public function getName()
    {
        return 'plan_repeat';
    }
}
