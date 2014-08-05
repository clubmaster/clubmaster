<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Field extends AbstractType
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
                'label_attr' => $label_attr
            ))
            ->add('information', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control',
                    'rows' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('open', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text'
            ))
            ->add('close', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('location', 'entity', array(
                'class' => 'ClubUserBundle:Location',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\BookingBundle\Entity\Field'
        ));
    }

    public function getName()
    {
        return 'admin_field';
    }
}
