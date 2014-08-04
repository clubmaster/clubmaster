<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminProfileEmail extends AbstractType
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
            ->add('email_address', 'text', array(
                'required' => false,
                'label_attr' => $label_attr,
                'attr' => $attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\ProfileEmail'
        ));
    }

    public function getName()
    {
        return 'admin_profile_email';
    }
}
