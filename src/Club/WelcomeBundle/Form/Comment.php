<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Comment extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', 'tinymce', array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label_attr' => array(
                    'class' => 'col-sm-2'
                )
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\WelcomeBundle\Entity\Comment'
        ));
    }

    public function getName()
    {
        return 'comment';
    }
}
