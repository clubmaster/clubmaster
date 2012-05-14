<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Schedule extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('description');
    $builder->add('penalty');
    $builder->add('max_attend');
    $builder->add('first_date');
    $builder->add('end_date');
    $builder->add('level');
    $builder->add('fields', 'entity', array(
      'class' => 'Club\BookingBundle\Entity\Field',
      'required' => false,
      'multiple' => true
    ));
    $builder->add('location');
    $builder->add('instructors','entity',array(
      'class' => 'Club\UserBundle\Entity\User',
      'required' => false,
      'multiple' => true,
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('u')
          ->leftJoin('u.groups', 'g')
          ->leftJoin('g.role', 'r')
          ->where('r.role_name = :role')
          ->setParameter('role', 'ROLE_STAFF');
      }
    ));
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\Schedule'
    );
  }

  public function getName()
  {
    return 'schedule';
  }
}
