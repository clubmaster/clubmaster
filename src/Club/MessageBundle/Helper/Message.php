<?php

namespace Club\MessageBundle\Helper;

class Message
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function migrateRecipients(\Club\MessageBundle\Entity\Message $message)
  {
    // just to check if user has received the message once
    $this->recipients = array();
    foreach ($message->getFilters() as $filter) {
      $this->processUsers($message, $this->em->getRepository('ClubUserBundle:User')->getUsers($filter));
    }

    $this->processUsers($message, $message->getUsers());

    foreach ($message->getGroups() as $group) {
      $this->processUsers($message, $group->getUsers());
    }

    foreach ($message->getEvents() as $event) {
      $this->processAttends($message, $event->getAttends());
    }
  }

  private function processAttends(\Club\MessageBundle\Entity\Message $message, $attends)
  {
    foreach ($attends as $attend) {
      if ($message->getType() == 'mail') {
        $this->addRecipient($message,$attend->getUser());
      }
    }
  }

  private function processUsers(\Club\MessageBundle\Entity\Message $message, $users)
  {
    foreach ($users as $user) {
      if ($message->getType() == 'mail') {
        $this->addRecipient($message,$user);
      }
    }
  }

  private function addRecipient(\Club\MessageBundle\Entity\Message $message, \Club\UserBundle\Entity\User $user)
  {
    if (isset($this->recipients[$user->getId()])) return;
    $this->recipients[$user->getId()] = 1;
    if (!$user->getProfile()->getProfileEmail()) return;

    $recipient = new \Club\MessageBundle\Entity\MessageRecipient();
    $recipient->setMessage($message);
    $recipient->setUser($user);
    $recipient->setRecipient($user->getProfile()->getProfileEmail()->getEmailAddress());

    $this->em->persist($recipient);
  }
}
