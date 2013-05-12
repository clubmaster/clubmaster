<?php

namespace Club\MailBundle\Listener;

class BookingListener
{
    protected $container;
    protected $em;
    protected $templating;
    protected $router;
    protected $translator;
    protected $clubmaster_mailer;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
        $this->translator = $container->get('translator');
        $this->clubmaster_mailer = $container->get('clubmaster_mailer');
    }

    public function onBookingConfirm(\Club\BookingBundle\Event\FilterBookingEvent $event)
    {
        $booking = $event->getBooking();
        $recipients = $this->getRecipients($booking);

        $this->clubmaster_mailer
            ->setSpool(false)
            ->setSubject($this->translator->trans('Booking confirm'))
            ->setFrom()
            ->setBody($this->templating->render('ClubMailBundle:Template:booking_confirm.html.twig', array(
                'user' => $booking->getUser(),
                'booking' => $booking,
            )))
            ->setDecorator($recipients)
            ;

        foreach ($recipients as $user) {
            $this->clubmaster_mailer
                ->setTo($user->getEmail())
                ->send()
                ;
        }
    }

    public function onBookingCancel(\Club\BookingBundle\Event\FilterBookingEvent $event)
    {
        $booking = $event->getBooking();
        $recipients = $this->getRecipients($booking);

        $this->clubmaster_mailer
            ->setSpool(false)
            ->setSubject($this->translator->trans('Booking cancel'))
            ->setFrom()
            ->setBody($this->templating->render('ClubMailBundle:Template:booking_cancel.html.twig',array(
                'user' => $booking->getUser(),
                'booking' => $booking,
            )))
            ->setDecorator($recipients)
            ;


        foreach ($recipients as $user) {
            $this->clubmaster_mailer
                ->setTo($user->getEmail())
                ->send();
        }
    }

    protected function getRecipients($booking)
    {
        $recipients = array();

        if ($booking->getUser()->getProfile()->getProfileEmail()) {
            if ($this->receiveMail($booking->getUser())) {
                $recipients[] = $booking->getUser();
            }
        }

        foreach ($booking->getUsers() as $user) {
            if ($this->receiveMail($user)) {
                if ($user->getProfile()->getProfileEmail()) {
                    $recipients[] = $user;
                }
            }
        }

        return $recipients;
    }

    protected function receiveMail(\Club\UserBundle\Entity\User $user)
    {
        $s = $this->em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
            'user' => $user->getId(),
            'attribute' => 'receive_email_on_booking'
        ));
        if ($s && !$s->getValue()) return false;
        if (!$s && !$this->container->getParameter('club_mail.mail_on_booking')) return false;

        return true;
    }
}
