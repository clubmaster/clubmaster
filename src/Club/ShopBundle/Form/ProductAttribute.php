<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductAttribute extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $res = range(1,100);
        $tickets = array();
        foreach ($res as $i) {
            $tickets[$i] = $i;
        }
        $res = range(1,10);
        $pauses = array();
        foreach ($res as $i) {
            $pauses[$i] = $i;
        }

        $bool = array(
            1 => 'Yes'
        );

        $renewal = array(
            'A' => 'After expire',
            'Y' => 'Yearly',
        );

        $builder->add('time_interval', 'text', array(
            'required' => false,
            'help' => array(
                'Info: What is the time interval for this subscription?',
                'Info: 1 month is <b>1M</b>',
                'Info: 1 month and 15 days is <b>1M15D</b>',
                'Info: 5 hours is <b>T5H</b>',
                'Info: 1 year, 5 hours and 15 minutes is <b>Y1T5H15M</b>'
            )
        ));
        $builder->add('ticket', 'choice', array(
            'required' => false,
            'choices' => $tickets,
            'help' => 'Info: How many tickets will the user get for this subscription?'
        ));
        $builder->add('auto_renewal', 'choice', array(
            'required' => false,
            'choices' => $renewal,
            'label' => 'Auto Renewal',
            'help' => 'Info: Will this subscription automatically be renewal?'
        ));
        $builder->add('allowed_pauses', 'choice', array(
            'required' => false,
            'choices' => $pauses,
            'label' => 'Allowed Pauses',
            'help' => 'Info: How many pauses is the user of this subscription allowed to take?'
        ));
        $builder->add('booking', 'choice', array(
            'required' => false,
            'choices' => $bool,
            'label' => 'Use booking',
            'help' => 'Info: Is allowed to use bookings?'
        ));
        $builder->add('team', 'choice', array(
            'required' => false,
            'choices' => $bool,
            'label' => 'Use team',
            'help' => 'Info: Is allowed to use teams?'
        ));
        $builder->add('only_member', 'choice', array(
            'required' => false,
            'choices' => $bool,
            'label' => 'Only for members',
            'help' => 'Info: Has to have active membership to buy product.'
        ));
        $builder->add('start_time', 'time', array(
            'required' => false,
            'label' => 'Start time',
            'help' => 'Info: From what time on day will user be active?'
        ));
        $builder->add('stop_time', 'time', array(
            'required' => false,
            'label' => 'Stop time',
            'help' => 'Info: What time on day will membership not be active anymore?'
        ));
        $builder->add('start_date', 'jquery_date', array(
            'widget' => 'single_text',
            'required' => false,
            'label' => 'Start date',
            'help' => 'Info: What will be the first day of this subscription?'
        ));
        $builder->add('expire_date', 'jquery_date', array(
            'widget' => 'single_text',
            'required' => false,
            'label' => 'Expire date',
            'help' => 'Info: When will subscription expire?'
        ));
        $builder->add('location','entity',array(
            'class' => 'Club\UserBundle\Entity\Location',
            'multiple' => true,
            'required' => false,
            'help' => 'Info: Which locations will the user be a member of?'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Model\Attribute'
        ));
    }

    public function getName()
    {
        return 'product_attribute';
    }
}
