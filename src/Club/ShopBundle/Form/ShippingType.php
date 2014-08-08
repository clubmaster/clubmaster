<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShippingType extends AbstractType
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
            ->add('shipping_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => $attr['class'],
                    'rows' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('price', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\Shipping'
        ));
    }

    public function getName()
    {
        return 'shipping';
    }
}
