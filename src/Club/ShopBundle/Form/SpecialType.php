<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecialType extends AbstractType
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
            ->add('product', 'entity', array(
                'class' => 'ClubShopBundle:Product',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('price', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('start_date', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text'
            ))
            ->add('expire_date', 'jquery_date', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'widget' => 'single_text'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\Special'
        ));
    }

    public function getName()
    {
        return 'special';
    }
}
