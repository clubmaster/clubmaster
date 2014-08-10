<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepetitionDaily extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $range = array();
        foreach (range(1,50) as $value) {
            $range[$value] = $value;
        }

        $builder
            ->add('first_date', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('last_date', 'jquery_datetime', array(
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('end_occurrences', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('type', 'hidden')
            ->add('repeat_every', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $range
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\TeamBundle\Entity\Repetition'
        ));
    }

    public function getName()
    {
        return 'repetition_daily';
    }
}
