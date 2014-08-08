<?php

namespace Club\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Event extends AbstractType
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
            ->add('event_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('description', 'tinymce', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('max_attends', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('price', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('start_date', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('stop_date', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('last_subscribe', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr

            ))
            ->add('street', 'textarea', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('postal_code', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('city', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('country', 'club_country', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('public', 'checkbox',  array(
                'help' => 'If the event should be visible for guests.'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\EventBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'event';
    }
}
