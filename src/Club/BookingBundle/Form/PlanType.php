<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanType extends AbstractType
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
                'help' => 'Info: When is the first date the plan will be valid from?'
            ))
            ->add('color', 'colorpicker', array(
                'attr' => array(
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                ),
                'label_attr' => $label_attr,
                'help' => 'Info: Click to select color.'
            ))
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control',
                    'rows' => 10
                ),
                'label_attr' => $label_attr,
                'help' => 'Info: When is the last day the plan will be valid?'
            ))
            ->add('start', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'Info: What time on the day will the plan be valid from?',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('end', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => 'Info: What time on the day will the plan end?',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('all_day', 'checkbox', array(
                'required' => false
            ))
            ->add('fields', 'entity', array(
                'class' => 'Club\BookingBundle\Entity\Field',
                'multiple' => true,
                'property' => 'formString',
                'help' => 'Info: What fields should be booked for the plan?',
                'label_attr' => $label_attr,
                'attr' => array(
                    'size' => 10,
                    'class' => 'form-control'
                )
            ))
            ->add('repeating', 'checkbox', array(
                'required' => false
            ))
            ->add('plan_repeats', 'collection', array(
                'label_attr' => $label_attr,
                'type' => new \Club\BookingBundle\Form\PlanRepeat()
            ))
            ;
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
