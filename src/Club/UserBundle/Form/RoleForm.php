<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\Form;

class RoleForm extends Form
{
  public function configure()
  {
    $this->setDataClass('Club\\UserBundle\\Entity\\Role');
    $this->add('role_name');
  }
}
