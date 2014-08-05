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
        $res = range(1,10);
        $amount_per_member = array();
        foreach ($res as $i) {
            $amount_per_member[$i] = $i;
        }
        $bool = array(
            1 => 'Yes'
        );
        $renewal = array(
            'A' => 'After expire',
            'Y' => 'Yearly',
        );

        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $builder
            ->add('time_interval', 'text', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'help' => array(
                    'Info: What is the time interval for this subscription?',
                    'Info: 1 month is <b>1M</b>',
                    'Info: 1 month and 15 days is <b>1M15D</b>',
                    'Info: 5 hours is <b>T5H</b>',
                    'Info: 1 year, 5 hours and 15 minutes is <b>Y1T5H15M</b>'
                )
            ))
            ->add('ticket', 'choice', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $tickets,
                'help' => 'Info: How many tickets will the user get for this subscription?'
            ))
            ->add('auto_renewal', 'choice', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $renewal,
                'label' => 'Auto Renewal',
                'help' => 'Info: Will this subscription automatically be renewal?'
            ))
            ->add('allowed_pauses', 'choice', array(
                'required' => false,
                'choices' => $pauses,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'label' => 'Allowed Pauses',
                'help' => 'Info: How many pauses is the user of this subscription allowed to take?'
            ))
            ->add('booking', 'choice', array(
                'required' => false,
                'choices' => $bool,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'label' => 'Use booking',
                'help' => 'Info: Is allowed to use bookings?'
            ))
            ->add('team', 'choice', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $bool,
                'label' => 'Use team',
                'help' => 'Info: Is allowed to use teams?'
            ))
            ->add('only_member', 'choice', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $bool,
                'label' => 'Only for members',
                'help' => 'Info: Has to have active membership to buy product.'
            ))
            ->add('amount_per_member', 'choice', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $amount_per_member,
                'label' => 'Amount per member',
                'help' => 'Info: How many of this product can a member buy.'
            ))
            ->add('start_time', 'time', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'label' => 'Start time',
                'help' => 'Info: From what time on day will user be active?'
            ))
            ->add('stop_time', 'time', array(
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'label' => 'Stop time',
                'help' => 'Info: What time on day will membership not be active anymore?'
            ))
            ->add('start_date', 'jquery_date', array(
                'widget' => 'single_text',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false,
                'label' => 'Start date',
                'help' => 'Info: What will be the first day of this subscription?'
            ))
            ->add('expire_date', 'jquery_date', array(
                'widget' => 'single_text',
                'required' => false,
                'attr' => $attr,
                'label_attr' => $label_attr,
                'label' => 'Expire date',
                'help' => 'Info: When will subscription expire?'
            ))
            ->add('location','entity',array(
                'class' => 'Club\UserBundle\Entity\Location',
                'attr' => $attr,
                'label_attr' => $label_attr,
                'multiple' => true,
                'required' => false,
                'help' => 'Info: Which locations will the user be a member of?'
            ))
            ;
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
