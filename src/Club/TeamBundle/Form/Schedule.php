<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Schedule extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $builder
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control',
                    'rows' => 10
                ),
                'label_attr' => $label_attr
            ))
            ->add('penalty', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('max_attend', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('first_date', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('end_date', 'jquery_datetime', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('level', 'entity', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'ClubTeamBundle:Level'
            ))
            ->add('fields', 'entity', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'ClubBookingBundle:Field',
                'required' => false,
                'multiple' => true
            ))
            ->add('location', 'entity', array(
                'class' => 'ClubUserBundle:Location',
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('instructors','entity',array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'class' => 'ClubUserBundle:User',
                'required' => false,
                'multiple' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->leftJoin('u.groups', 'g')
                        ->leftJoin('g.role', 'r')
                        ->where('r.role_name = :role')
                        ->setParameter('role', 'ROLE_STAFF');
                }
        ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\TeamBundle\Entity\Schedule'
        ));
    }

    public function getName()
    {
        return 'schedule';
    }
}
