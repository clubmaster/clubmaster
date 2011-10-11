<?php

namespace Club\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Task extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('task_interval');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\TaskBundle\Entity\Task'
    );
  }

  public function getName()
  {
    return 'task';
  }
}
