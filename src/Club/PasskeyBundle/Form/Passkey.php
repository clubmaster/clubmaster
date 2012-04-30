<?php

namespace Club\PasskeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Passkey extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('key_identity');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\PasskeyBundle\Entity\Passkey'
    );
  }

  public function getName()
  {
    return 'passkey';
  }
}
