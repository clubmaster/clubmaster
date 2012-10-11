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
        $repeats = array(
            'hourly' => 'Hourly',
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

        $builder->add('repeats', 'choice', array(
            'choices' => $repeats
        ));
        $builder->add('repeat_on', 'day', array(
            'multiple' => 'true'
        ));
        $builder->add('repeat_by', 'choice', array(
            'choices' => $repeat_by
        ));
        $builder->add('repeat_every', 'choice', array(
            'choices' => $repeat_every
        ));
        $builder->add('starts_on', 'jquery_date', array(
            'widget' => 'single_text'
        ));
        $builder->add('ends_type', 'choice', array(
            'choices' => $ends_type
        ));
        $builder->add('ends_after');
        $builder->add('ends_on', 'jquery_date', array(
            'widget' => 'single_text'
        ));
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
