<?php

namespace Club\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Ticker extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'textarea', array(
            'attr' => array(
                'class' => 'big'
            )
        ));
        $builder->add('start_date', 'jquery_datetime', array(
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
        $builder->add('end_date', 'jquery_datetime', array(
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\NewsBundle\Entity\Ticker'
        ));
    }

    public function getName()
    {
        return 'ticker';
    }
}
