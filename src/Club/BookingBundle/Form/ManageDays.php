<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManageDays extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('start_date', 'jquery_date', array(
        'widget' => 'single_text'
    ));

    $date = new \DateTime('next monday');
    $int = new \DateInterval('P1D');
    $period = new \DatePeriod($date, $int, 7);

    foreach ($period as $dt) {
      $builder->add($dt->format('N'), new ManageInterval());
    }
  }

  public function getName()
  {
    return 'manage_day';
  }
}
