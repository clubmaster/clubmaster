<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanExceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exclude_date', 'jquery_datetime', array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label_attr' => array(
                    'class' => 'col-sm-2'
                ),
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\BookingBundle\Entity\PlanException'
        ));
    }

    public function getName()
    {
        return 'plan_exception';
    }
}
