<?php

namespace Club\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\MailBundle\Repository\MailQueue")
 * @ORM\Table(name="club_mail_queue")
 */
class MailQueue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var text $message
     */
    private $message;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $error_message
     */
    private $error_message;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $priority
     */
    private $priority;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return text $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set error_message
     *
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->error_message = $errorMessage;
    }

    /**
     * Get error_message
     *
     * @return string $errorMessage
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get priority
     *
     * @return integer $priority
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
