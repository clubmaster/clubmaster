<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JQueryDateTimeType extends AbstractType
{
    public function getParent()
    {
        return 'datetime';
    }

    public function getName()
    {
        return 'jquery_datetime';
    }
}
