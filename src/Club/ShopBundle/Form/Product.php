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
        $builder
            ->add('product_name')
            ->add('description', 'tinymce', array(
                'required' => true,
                'attr' => array(
                    'rows' => 15
                )
            ))
            ->add('price')
            ->add('priority', 'integer', array(
                'help' => 'Where to list the product in shop view, higher rated higher.'
            ))
            ->add('quantity', 'integer', array(
                'help' => 'Amount in stock, -1 if unlimited'
            ))
            ->add('categories')
            ->add('account_number', 'text', array(
                'required' => false,
                'help' => 'Account number in accounting program'
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
