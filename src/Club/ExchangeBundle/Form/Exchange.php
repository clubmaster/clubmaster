<?php

namespace Club\ExchangeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Exchange extends AbstractType
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
            ->add('location', 'entity', array(
                'class' => 'ClubUserBundle:Location',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('play_time', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('message', 'textarea', array(
                'label_attr' => $label_attr,
                'attr' => array(
                    'class' => $attr['class'],
                    'rows' => 10
                )
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ExchangeBundle\Entity\Exchange'
        ));
    }

    public function getName()
    {
        return 'exchange';
    }
}
