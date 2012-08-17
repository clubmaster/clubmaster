<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdministratorProfile extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $gender = array('male'=>'Male','female'=>'Female');
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('day_of_birth','birthday');
    $builder->add('gender','choice',array(
      'choices' => $gender
    ));
    $builder->add('profile_email', new \Club\InstallerBundle\Form\AdministratorEmail());
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Profile'
    );
  }

  public function getName()
  {
    return 'administrator_profile';
  }
}
