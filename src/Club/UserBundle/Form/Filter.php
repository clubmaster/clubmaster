<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Filter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $age = range(0,120);
        $boolean = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        $yes = array(
            '1' => 'Yes',
        );

        $builder
            ->add('name','text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('phone','text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('email_address','text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('member_number', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('min_age', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $age,
                'required' => false
            ))
            ->add('max_age', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $age,
                'required' => false
            ))
            ->add('gender', 'gender', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('postal_code', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('city', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('country', 'club_country', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('has_ticket', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $boolean,
                'required' => false
            ))
            ->add('location', 'entity', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'Club\UserBundle\Entity\Location',
                'required' => false,
                'multiple' => true
            ))
            ->add('subscription_from', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false,
                'widget' => 'single_text'
            ))
            ->add('subscription_to', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false,
                'widget' => 'single_text'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Filter\UserFilter'
        ));
    }

    public function getName()
    {
        return 'filter';
    }
}
