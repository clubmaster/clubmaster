<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Field extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('position');
    $builder->add('information');
    $builder->add('open');
    $builder->add('close');
    $builder->add('location','entity',array(
      'class' => 'Club\UserBundle\Entity\Location',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('l')
          ->where('l.id <> 1');
      }
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\BookingBundle\Entity\Field'
    );
  }

  public function getName()
  {
    return 'admin_field';
  }
}
