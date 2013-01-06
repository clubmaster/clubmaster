<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JQueryBirthdayType extends AbstractType
{
    public function getParent()
    {
        return 'birthday';
    }

    public function getName()
    {
        return 'jquery_birthday';
    }
}
