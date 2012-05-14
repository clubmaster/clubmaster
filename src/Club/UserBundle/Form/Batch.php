<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Batch extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
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

  public function getDefaultOptions()
  {
    return array();
  }

  public function getName()
  {
    return 'batch';
  }
}

