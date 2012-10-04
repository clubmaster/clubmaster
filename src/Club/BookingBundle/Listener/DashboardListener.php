<?php

namespace Club\BookingBundle\Listener;

class DashboardListener
{
  private $container;
  private $em;
  private $security_context;
  private $templating;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->templating = $container->get('templating');
  }

  public function onMemberView(\Club\UserBundle\Event\FilterActivityEvent $event)
  {
    if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) return;

    $user = $event->getUser();

    $s = $this->em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
      'user' => $user->getId(),
      'attribute' => 'public_booking_activity'
    ));
    if ($s && !$s->getValue()) return;
    if (!$s && !$this->container->getParameter('club_booking.public_user_activity')) return;

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getLatest($user);

    foreach ($bookings as $b) {
        $activity = array(
            'date' => $b->getFirstDate(),
            'type' => 'bundles/clublayout/images/icons/16x16/time.png',
            'message' => $this->templating->render('ClubBookingBundle:Dashboard:booking_message.html.twig', array(
                'booking' => $b,
                'user' => $user
            ))
        );
        $event->appendActivities($activity, $b->getFirstDate()->format('U'));
    }
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $start = new \DateTime();

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllFutureBookings($this->security_context->getToken()->getUser(), $start);
    $output .= $this->templating->render('ClubBookingBundle:Dashboard:booking_table.html.twig', array(
      'bookings' => $bookings
    ));

    $event->setOutput($output);
  }
}
