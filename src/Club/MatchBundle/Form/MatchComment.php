<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MatchComment extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('comment');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\MatchBundle\Entity\MatchComment'
    );
  }

  public function getName()
  {
    return 'match_comment';
  }
}
