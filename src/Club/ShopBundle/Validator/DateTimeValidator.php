<?php

namespace Club\ShopBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateTimeValidator extends ConstraintValidator
{
  public function isValid($value, Constraint $constraint)
  {
    try {
      $date = new \DateInterval('P'.$value);
    } catch (\Exception $e) {
      $this->setMessage($constraint->message);
      return false;
    }

    return true;
  }
}
