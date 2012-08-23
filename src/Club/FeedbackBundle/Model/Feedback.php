<?php

namespace Club\FeedbackBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Feedback
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
    * @Assert\Notblank()
     */
    public $type;

    /**
     * @Assert\NotBlank()
     */
    public $subject;

    /**
     * @Assert\NotBlank()
     */
    public $message;

    public $host;
}
