<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class UserGroup extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('groups','entity',array(
      'class' => 'Club\UserBundle\Entity\Group',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('g')
          ->where("g.group_type=:type")
          ->setParameter('type','static');
      },
      'multiple' => true
    ));
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User'
    );
  }

  public function getName()
  {
    return 'user_group';
  }
}
