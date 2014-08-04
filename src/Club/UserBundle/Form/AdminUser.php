<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminUser extends AbstractType
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
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_name' => 'Password',
                'second_name' => 'Password_again',
                'required' => false,
                'options' => array(
                    'attr' => $attr,
                    'label_attr' => $label_attr
                )
            ))
            ->add('member_number','text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('profile', new \Club\UserBundle\Form\AdminProfile())
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\User',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'admin_user';
    }
}
