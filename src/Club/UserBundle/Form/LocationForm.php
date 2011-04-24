<?php
namespace Club\UserBundle\Form;

use Symfony\Component\Form\Form;

class LocationForm extends Form
{
  public function configure()
  {
    $this->setDataClass('Club\\UserBundle\\Entity\\Location');
    $this->add('location_name');
    $this->add('location');
  }
}
