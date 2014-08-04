<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2 control-label'
        );

        $bool = array(
            '0' => 'No',
            '1' => 'Yes'
        );
        $builder
            ->add('group_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('group_type','choice',array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => array(
                    'static' => 'Static',
                    'dynamic' => 'Dynamic'
                )
            ))
            ->add('active_member','choice',array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $bool,
                'required' => false
            ))
            ->add('min_age', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
            ))
            ->add('max_age', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
            ))
            ->add('gender','gender',array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('location', 'entity', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'ClubUserBundle:Location',
                'multiple' => true,
                'required' => false
            ))
            ->add('role', 'entity', array(
                'attr' => array(
                    'class' => 'form-control',
                    'size' => 8
                ),
                'label_attr' => $label_attr,
                'class' => 'ClubUserBundle:Role',
                'multiple' => true,
                'required' => false,
                'help' => 'Info: The members of this group will get all the roles that you select in this field.'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\Group'
        ));
    }

    public function getName()
    {
        return 'group';
    }
}
