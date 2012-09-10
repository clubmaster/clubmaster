<?php

namespace Club\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Club\LayoutBundle\Form\TinyMceType;

class Welcome extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('content', new TinyMceType());
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\WelcomeBundle\Entity\Welcome'
    ));
  }

  public function getName()
  {
    return 'welcome';
  }
}
