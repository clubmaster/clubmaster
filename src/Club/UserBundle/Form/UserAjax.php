<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserAjax extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', 'jquery_autocomplete', array(
            'attr' => array(
                'class' => 'form-control'
            ),
            'label_attr' => array(
                'class' => 'col-sm-2'
            )
        ));
    }

    public function getName()
    {
        return 'user_ajax';
    }
}
