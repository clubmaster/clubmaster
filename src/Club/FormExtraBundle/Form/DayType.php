<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Club\FormExtraBundle\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DayType extends AbstractType
{
    private $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                '1' => $this->translator->trans('Monday'),
                '2' => $this->translator->trans('Tuesday'),
                '3' => $this->translator->trans('Wednesday'),
                '4' => $this->translator->trans('Thursday'),
                '5' => $this->translator->trans('Friday'),
                '6' => $this->translator->trans('Saturday'),
                '7' => $this->translator->trans('Sunday')
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'day';
    }
}
