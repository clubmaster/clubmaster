<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminProfileEmail extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $types = array(
      'home' => 'Home',
      'business' => 'Business'
    );
    $builder->add('contact_type', 'choice', array(
      'choices' => $types
    ));
    $builder->add('email_address');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Entity\ProfileEmail'
    ));
  }

  public function getName()
  {
    return 'admin_profile_email';
  }
}
