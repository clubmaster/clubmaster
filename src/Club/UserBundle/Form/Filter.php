<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Filter extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $age = range(0,120);
    $boolean = array(
      '1' => 'Yes',
      '0' => 'No'
    );
    $yes = array(
      '1' => 'Yes',
    );

    $builder->add('name','text', array(
      'required' => false
    ));
    $builder->add('phone','text', array(
      'required' => false
    ));
    $builder->add('email_address','text', array(
      'required' => false
    ));
    $builder->add('member_number', 'text', array(
      'required' => false
    ));
    $builder->add('min_age', 'choice', array(
      'choices' => $age,
      'required' => false
    ));
    $builder->add('max_age', 'choice', array(
      'choices' => $age,
      'required' => false
    ));
    $builder->add('gender', 'gender', array(
      'required' => false
    ));
    $builder->add('postal_code', 'text', array(
      'required' => false
    ));
    $builder->add('city', 'text', array(
      'required' => false
    ));
    $builder->add('country', 'club_country', array(
      'required' => false
    ));
    $builder->add('has_ticket', 'choice', array(
      'choices' => $boolean,
      'required' => false
    ));
    $builder->add('location', 'entity', array(
      'class' => 'Club\UserBundle\Entity\Location',
      'required' => false,
      'multiple' => true
    ));
    $builder->add('subscription_from', 'jquery_date', array(
        'required' => false,
        'widget' => 'single_text'
    ));
    $builder->add('subscription_to', 'jquery_date', array(
        'required' => false,
        'widget' => 'single_text'
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\UserBundle\Filter\UserFilter'
    ));
  }

  public function getName()
  {
    return 'filter';
  }
}
