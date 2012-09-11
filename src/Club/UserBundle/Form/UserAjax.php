<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Club\LayoutBundle\Form\JQueryAutocompleteType;

class UserAjax extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('user', new JQueryAutocomplete());
  }

  public function getName()
  {
    return 'user_ajax';
  }
}
