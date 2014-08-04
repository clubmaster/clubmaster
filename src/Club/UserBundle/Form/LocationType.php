<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocationType extends AbstractType
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
            ->add('location_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('club', 'text', array(
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
            ->add('state', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('country', 'club_country', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('location','entity', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'Club\UserBundle\Entity\Location',
                'required' => false
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\Location'
        ));
    }

    public function getName()
    {
        return 'location';
    }
}
