<?php

namespace Club\MailBundle\Helper;

class SwiftReporter implements \Swift_Plugins_Reporter
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function notify(\Swift_Mime_Message $message, $address, $result)
  {
    $error = (self::RESULT_PASS == $result) ? 0 : 1;

    $log = new \Club\MailBundle\Entity\Log();
    $log->setMessage($message);
    $log->setError($error);
    $log->setRecipient($address);

    $this->em->persist($log);
    $this->em->flush();
  }
}
