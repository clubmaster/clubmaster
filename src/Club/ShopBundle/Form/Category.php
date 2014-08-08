<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Category extends AbstractType
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
            ->add('category_name', 'text', array(
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
            ->add('category','entity',array(
                'class' => 'Club\ShopBundle\Entity\Category',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('location','entity',array(
                'class' => 'Club\UserBundle\Entity\Location',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->where('l.club = 1');
                }
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'category';
    }
}
