<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Blog extends AbstractType
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
            ->add('title', 'text', array(
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
            'data_class' => 'Club\WelcomeBundle\Entity\Blog'
        ));
    }

    public function getName()
    {
        return 'blog';
    }
}
