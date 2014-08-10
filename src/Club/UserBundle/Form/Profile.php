<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Profile extends AbstractType
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
            ->add('first_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('last_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('gender','gender', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('day_of_birth', 'birthday', array(
                'label_attr' => $label_attr
            ))
            ->add('profile_address', new \Club\UserBundle\Form\ProfileAddress())
            ->add('profile_emails', 'collection', array(
                'type' => new \Club\UserBundle\Form\ProfileEmail()
            ))
            ->add('profile_phone', new \Club\UserBundle\Form\ProfilePhone())
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\Profile'
        ));
    }

    public function getName()
    {
        return 'profile';
    }
}
