<?php

namespace Club\ExchangeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExchangeComment extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('comment', 'textarea', array(
            'attr' => array(
                'class' => 'form-control',
                'rows' => 10
            ),
            'label_attr' => array(
                'class' => 'col-sm-2'
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ExchangeBundle\Entity\ExchangeComment'
        ));
    }

    public function getName()
    {
        return 'exchange_comment';
    }
}
