<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserGroup extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\User'
    ));
  }

  public function getName()
  {
    return 'user_group';
  }
}
