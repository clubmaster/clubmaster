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
    $this->em = $container->get('doctrine.orm.default_entity_manager');
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
    $this->process($event, $bookings);
  }

  public function onDashboardComing(\Club\UserBundle\Event\FilterActivityEvent $event)
  {
    $start = new \DateTime();
    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllFutureBookings($event->getUser(), $start);

    $this->process($event, $bookings);
  }

  private function process($event, $bookings)
  {
    foreach ($bookings as $b) {
        $activity = array(
            'date' => $b->getFirstDate(),
            'type' => 'bundles/clublayout/images/icons/16x16/time.png',
            'message' => $this->templating->render('ClubBookingBundle:Dashboard:booking_message.html.twig', array(
                'booking' => $b,
                'user' => $event->getUser()
            ))
        );
        $event->appendActivities($activity, $b->getFirstDate()->format('U'));
    }
  }
}
