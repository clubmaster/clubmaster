<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileAddress extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('street');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('state');
    $builder->add('country', 'club_country');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\ProfileAddress'
    ));
  }

  public function getName()
  {
    return 'profile_address';
  }
}
