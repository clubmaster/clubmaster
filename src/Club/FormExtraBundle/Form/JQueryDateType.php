<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JQueryDateType extends AbstractType
{
    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'jquery_date';
    }
}
