<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Profile extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('gender','gender');
    $builder->add('day_of_birth', 'jquery_birthday', array(
        'widget' => 'single_text'
    ));
    $builder->add('profile_address', new \Club\UserBundle\Form\ProfileAddress());
    $builder->add('profile_emails', 'collection', array(
        'type' => new \Club\UserBundle\Form\ProfileEmail()
    ));
    $builder->add('profile_phone', new \Club\UserBundle\Form\ProfilePhone());
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\Profile'
    ));
  }

  public function getName()
  {
    return 'profile';
  }
}
