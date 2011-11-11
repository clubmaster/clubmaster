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
    $builder->add('max_attend');
    $builder->add('first_date');
    $builder->add('end_date');
    $builder->add('level');
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
      'data_class' => 'Club\TeamBundle\Entity\Schedule'
    );
  }

  public function getName()
  {
    return 'schedule';
  }
}
