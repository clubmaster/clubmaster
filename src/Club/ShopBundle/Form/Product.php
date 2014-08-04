<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Product extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'cotrol-label col-sm-2'
        );

        $builder
            ->add('product_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('description', 'tinymce', array(
                'required' => true,
                'attr' => array(
                    'rows' => 15,
                    'class' => $attr['class']
                ),
                'label_attr' => $label_attr
            ))
            ->add('price', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('priority', 'integer', array(
                'help' => 'Where to list the product in shop view, higher rated higher.',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('quantity', 'integer', array(
                'help' => 'Amount in stock, -1 if unlimited',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('categories', 'entity', array(
                'multiple' => true,
                'class' => 'ClubShopBundle:Category',
                'attr' => array(
                    'class' => $attr['class'],
                    'size' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('account_number', 'text', array(
                'required' => false,
                'help' => 'Account number in accounting program',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('image', new ImageType())
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\Product',
            'attr' => array(
                'class' => 'form-horizontal'
            )
        ));
    }

    public function getName()
    {
        return 'club_shop_product';
    }
}
