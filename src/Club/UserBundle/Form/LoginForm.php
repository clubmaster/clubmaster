<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\PasswordField;

class LoginForm extends Form
{
  public function configure()
  {
    $this->add(new TextField('_username'));
    $this->add(new PasswordField('_password'));
  }
}
