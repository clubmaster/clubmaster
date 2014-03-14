<?php

namespace Club\ShopBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateTime extends Constraint
{
    public $message = 'This value is not a valid format.';
}
