<?php

namespace Club\InstallerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocationStep extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('location_name','text',array(
      'required' => true
    ));
    $builder->add('currency','entity',array(
      'class' => 'Club\UserBundle\Entity\Currency'
    ));
  }

  public function getName()
  {
    return 'location_step';
  }
}
