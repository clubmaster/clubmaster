<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamCategory extends AbstractType
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
            ->add('team_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control',
                    'rows' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('penalty', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\TeamBundle\Entity\TeamCategory'
        ));
    }

    public function getName()
    {
        return 'team_category';
    }
}
