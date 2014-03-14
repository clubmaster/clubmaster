<?php

namespace Club\ShopBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateTimeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!strlen($value))
            return true;

        try {
            $date = new \DateInterval('P'.$value);

        } catch (\Exception $e) {
            $this->context->addViolation($constraint->message, array('%string%' => $value));
        }
    }
}
