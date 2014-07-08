<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('profile', new \Club\UserBundle\Form\ProfileGuest());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\UserBundle\Entity\User',
            'cascade_validation' => true,
            'validation_groups' => 'guest'
        ));
    }

    public function getName()
    {
        return 'guest_user';
    }
}
