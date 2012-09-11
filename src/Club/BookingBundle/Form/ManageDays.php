<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Club\LayoutBundle\Form\JQueryDateType;

class ManageDays extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('start_date', new JQueryDateType(), array(
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
