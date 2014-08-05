<?php

namespace Club\MessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groups', 'entity', array(
                'class' => 'ClubUserBundle:Group',
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'size' => 20
                ),
                'label_attr' => array(
                    'class' => 'col-sm-2'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\MessageBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'message_groups';
    }
}
