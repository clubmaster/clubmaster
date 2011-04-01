<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\Form;

class UserForm extends Form
{
  public function configure()
  {
    $this->setDataClass('Club\\UserBundle\\Entity\\User');
    $this->add('username');
    $this->add('password');
  }
}
