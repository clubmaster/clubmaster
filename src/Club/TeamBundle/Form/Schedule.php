<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Schedule extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('description');
    $builder->add('penalty');
    $builder->add('max_attend');
    $builder->add('first_date', 'datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
    $builder->add('end_date', 'datetime', array(
        'date_widget' => 'single_text',
        'time_widget' => 'single_text'
    ));
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\TeamBundle\Entity\Schedule'
    ));
  }

  public function getName()
  {
    return 'schedule';
  }
}
