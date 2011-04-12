<?php

namespace Club\MailBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\MailBundle\Repository\MailQueue")
 * @orm:Table(name="club_mail_queue")
 */
class MailQueue
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="text")
     *
     * @var text $message
     */
    private $message;

    /**
     * @orm:Column(type="string")
     *
     * @var string $error_message
     */
    private $error_message;

    /**
     * @orm:Column(type="integer")
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
