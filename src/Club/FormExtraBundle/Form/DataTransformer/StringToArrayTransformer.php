<?php

namespace Club\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;

class StringToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a string.
     *
     * @param  Array|null $array
     * @return string
     */
    public function transform($string)
    {
        $r = explode(",", $string);

        return $r;
    }

    /**
     * Transforms a string to an array.
     *
     * @param  string $string
     * @return Array|null
     */
    public function reverseTransform($array)
    {
        $r = implode(",", $array);

        return $r;
    }
}
