<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministratorProfile extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('day_of_birth','jquery_birthday', array(
      'widget' => 'single_text'
    ));
    $builder->add('gender','gender');
    $builder->add('profile_emails', 'collection', array(
      'type' => new \Club\UserBundle\Form\AdminProfileEmail()
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'Club\UserBundle\Entity\Profile'
      ));
  }

  public function getName()
  {
    return 'administrator_profile';
  }
}
