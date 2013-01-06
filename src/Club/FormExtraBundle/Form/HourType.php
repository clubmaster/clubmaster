<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Club\FormExtraBundle\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HourType extends AbstractType
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
        $d = new \DateTime('1970-01-01 00:00:00');
        $i = new \DateInterval('PT1H');
        $p = new \DatePeriod($d, $i, 23);

        $choices = array();
        foreach ($p as $date) {
            $choices[$date->format('H')] = $date->format('H:00');
        }

        $resolver->setDefaults(array(
            'choices' => $choices
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'hour';
    }
}
