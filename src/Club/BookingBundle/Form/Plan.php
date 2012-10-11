<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Plan extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'help' => 'Info: When is the first date the plan will be valid from?'
        ));
        $builder->add('description', 'textarea', array(
            'help' => 'Info: When is the last day the plan will be valid?'
        ));
        $builder->add('start', 'datetime', array(
            'help' => 'Info: What time on the day will the plan be valid from?',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
        $builder->add('end', 'datetime', array(
            'help' => 'Info: What time on the day will the plan end?',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
        $builder->add('all_day');
        $builder->add('fields', 'entity', array(
            'class' => 'Club\BookingBundle\Entity\Field',
            'multiple' => true,
            'property' => 'formString',
            'help' => 'Info: What fields should be booked for the plan?'
        ));
        $builder->add('repeat');
        $builder->add('plan_repeats', 'collection', array(
            'type' => new \Club\BookingBundle\Form\PlanRepeat()
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\BookingBundle\Entity\Plan'
        ));
    }

    public function getName()
    {
        return 'plan';
    }
}
