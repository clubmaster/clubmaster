<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\Form;

class GroupForm extends Form
{
  public function configure()
  {
    $this->setDataClass('Club\\UserBundle\\Entity\\Group');
    $this->add('group_name');
    $this->add('group');
  }
}
