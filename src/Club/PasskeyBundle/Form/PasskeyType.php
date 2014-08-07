<?php

namespace Club\PasskeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PasskeyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key_identity', 'text', array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label_attr' => array(
                    'class' => 'col-sm-2'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\PasskeyBundle\Entity\Passkey'
        ));
    }

    public function getName()
    {
        return 'passkey';
    }
}
