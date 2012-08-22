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
    $builder->add('category_name');
    $builder->add('description');
    $builder->add('category','entity',array(
      'class' => 'Club\ShopBundle\Entity\Category',
      'required' => false
    ));
    $builder->add('location','entity',array(
      'class' => 'Club\UserBundle\Entity\Location',
      'required' => true,
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilderInterface('l')
          ->where('l.club = 1');
      }
    ));
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
