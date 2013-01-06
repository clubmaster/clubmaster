<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HelpTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('help', $options['help']);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($form->getAttribute('help')) {
            if (!is_array($form->getAttribute('help'))) {
                $help = array($form->getAttribute('help'));
            } else {
                $help = $form->getAttribute('help');
            }

            $view->set('help', $help);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'help' => null,
        ));
    }

    public function getExtendedType()
    {
        return 'field';
    }
}

