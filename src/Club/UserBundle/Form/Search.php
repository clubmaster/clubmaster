<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Search extends UserAjax
{
    public function getName()
    {
        return 'search';
    }
}
