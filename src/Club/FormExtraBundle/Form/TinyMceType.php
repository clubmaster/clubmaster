<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TinyMceType extends AbstractType
{
    public function getParent()
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'tinymce';
    }
}
