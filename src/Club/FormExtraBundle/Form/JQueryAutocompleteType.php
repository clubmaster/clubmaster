<?php

namespace Club\FormExtraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Club\UserBundle\Form\DataTransformer\UserToNumberTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JQueryAutocompleteType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    private $translator;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $translator)
    {
        $this->om = $om;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new UserToNumberTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => $this->translator->trans('The user does not exist'),
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'jquery_autocomplete';
    }
}
