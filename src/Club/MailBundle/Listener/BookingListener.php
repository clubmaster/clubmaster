<?php

namespace Club\MailBundle\Listener;

class BookingListener
{
  protected $em;
  protected $templating;
  protected $router;
  protected $clubmaster_mailer;

  public function __construct($em, $templating, $router, $clubmaster_mailer)
  {
    $this->em = $em;
    $this->templating = $templating;
    $this->router = $router;
    $this->clubmaster_mailer = $clubmaster_mailer;
  }

  public function onBookingConfirm(\Club\BookingBundle\Event\FilterBookingEvent $event)
  {
    $booking = $event->getBooking();
    $recipients = $this->getRecipients($booking);

    foreach ($recipients as $user) {
      $this->clubmaster_mailer
        ->setSubject('Booking confirm')
        ->setFrom()
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
    $booking = $event->getBooking();
    $recipients = $this->getRecipients($booking);

    foreach ($recipients as $user) {
      $this->clubmaster_mailer
        ->setSubject('Booking cancel')
        ->setFrom()
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
