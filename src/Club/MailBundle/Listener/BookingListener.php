<?php

namespace Club\MailBundle\Listener;

class BookingListener
{
  protected $container;
  protected $em;
  protected $templating;
  protected $router;
  protected $clubmaster_mailer;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->templating = $container->get('templating');
    $this->router = $container->get('router');
    $this->clubmaster_mailer = $container->get('clubmaster_mailer');
  }

  public function onBookingConfirm(\Club\BookingBundle\Event\FilterBookingEvent $event)
  {
    if (!$this->container->getParameter('club_mail.mail_on_booking')) return false;

    $booking = $event->getBooking();
    $recipients = $this->getRecipients($booking);

    $this->clubmaster_mailer
      ->setSubject('Booking confirm')
      ->setFrom();

    foreach ($recipients as $user) {
      $this->clubmaster_mailer
        ->setTo($user->getProfile()->getProfileEmail()->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:booking_confirm.html.twig', array(
          'user' => $user,
          'booking' => $booking,
        )))
        ->send();
    }
  }

  public function onBookingCancel(\Club\BookingBundle\Event\FilterBookingEvent $event)
  {
    if (!$this->container->getParameter('club_mail.mail_on_booking')) return false;

    $booking = $event->getBooking();
    $recipients = $this->getRecipients($booking);

    $this->clubmaster_mailer
      ->setSubject('Booking cancel')
      ->setFrom();

    foreach ($recipients as $user) {
      $this->clubmaster_mailer
        ->setTo($user->getProfile()->getProfileEmail()->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:booking_cancel.html.twig',array(
          'user' => $user,
          'booking' => $booking,
        )))
        ->send();
    }
  }

  protected function getRecipients($booking)
  {
    $recipients = array();

    if ($booking->getUser()->getProfile()->getProfileEmail()) {
      $recipients[] = $booking->getUser();
    }

    foreach ($booking->getUsers() as $user) {
      if ($user->getProfile()->getProfileEmail()) {
        $recipients[] = $user;
      }
    }

    return $recipients;
  }
}
