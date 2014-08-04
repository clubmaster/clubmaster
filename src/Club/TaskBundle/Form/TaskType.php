<?php

namespace Club\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $interval = array(
            'T1M' => 'Every minute',
            'T5M' => 'Every 5 minute',
            'T10M' => 'Every 10 minute',
            'T15M' => 'Every 15 minute',
            'T30M' => 'Every 30 minute',
            'T1H' => 'Every hour',
            'T6H' => 'Every 6 hour',
            '1D' => 'Every day',
            '2D' => 'Every 2. day',
            '3D' => 'Every 3. day',
            '7D' => 'Every week',
            '14D' => 'Every 2. week',
            '1M' => 'Every month',
            '2M' => 'Every 2. month',
            '1Y' => 'Every year'
        );

        $builder
            ->add('task_interval', 'choice', array(
                'choices' => $interval,
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label_attr' => array(
                    'class' => 'col-sm-2'
                )
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\TaskBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'task';
    }
}
