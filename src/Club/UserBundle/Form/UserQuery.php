<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserQuery extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('id', 'hidden');
    $builder->add('query', 'text');
    $builder->add('sort', 'choice', array(
      'choices' => array(
        'u.member_number' => 'Member number',
        'p.first_name' => 'First name',
        'p.last_name' => 'Last name'
      )
    ));
  }

  public function getName()
  {
    return 'query';
  }
}
