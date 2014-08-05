<?php

namespace Club\MessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Message extends AbstractType
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
            ->add('sender_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('sender_address', 'email', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('subject', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('message', 'tinymce', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\MessageBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'message';
    }
}
