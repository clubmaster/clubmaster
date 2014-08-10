<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $arr = array();
        for ($i = 1; $i < 50; $i++) {
            $arr[$i] = $i;
        }

        $builder
            ->add('coupon_key', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('value', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr)
            )
            ->add('max_usage','choice',array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $arr
            ))
            ->add('expire_at', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\Coupon'
        ));
    }

    public function getName()
    {
        return 'coupon';
    }
}
