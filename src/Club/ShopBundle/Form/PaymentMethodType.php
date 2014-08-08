<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentMethodType extends AbstractType
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
            ->add('payment_method_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('controller', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('priority', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('success_page', 'tinymce', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('error_page', 'tinymce', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\PaymentMethod'
        ));
    }

    public function getName()
    {
        return 'payment_method';
    }
}
