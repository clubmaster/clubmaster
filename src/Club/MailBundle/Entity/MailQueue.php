<?php

namespace Club\MailBundle\Entity;

/**
 * Club\MailBundle\Entity\MailQueue
 */
class MailQueue
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $message
     */
    private $message;

    /**
     * @var string $error_message
     */
    private $error_message;

    /**
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