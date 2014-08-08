<?php

namespace Club\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Announcement extends AbstractType
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
            ->add('message', 'textarea', array(
                'attr' => array(
                    'class' => $attr['class'],
                    'rows' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('start_date', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('end_date', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\NewsBundle\Entity\Announcement',
            'attr' => array(
                'class' => 'form-horizontal',
                'role' => 'form'
            )
        ));
    }

    public function getName()
    {
        return 'announcement';
    }
}
