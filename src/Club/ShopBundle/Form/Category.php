<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Category extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
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
        return $er->createQueryBuilder('l')
          ->where('l.club = 1');
      }
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Category'
    );
  }

  public function getName()
  {
    return 'category';
  }
}
