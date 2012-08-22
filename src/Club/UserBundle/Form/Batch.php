<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Batch extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $res = array(
      'password_expire' => 'Password expire',
      'subscription_expire' => 'Subscription expire'
    );
    $builder->add('batch', 'choice', array(
      'choices' => $res,
      'required' => false
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array());
  }

  public function getName()
  {
    return 'batch';
  }
}

