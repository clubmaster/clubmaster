<?php

namespace Club\WelcomeBundle\Listener;

class DashboardListener
{
  private $container;
  private $em;
  private $security_context;
  private $templating;
  private $router;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->templating = $container->get('templating');
    $this->router = $container->get('router');
  }

  public function onMemberView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $user = $event->getUser();

    $blogs = $this->em->getRepository('ClubWelcomeBundle:Blog')->findBy(
        array('user' => $user->getId()),
        array('id' => 'DESC'),
        10
    );

    foreach ($blogs as $b) {

        $activity = array(
            'date' => $b->getCreatedAt(),
            'type' => 'bundles/clublayout/images/icons/16x16/transmit.png',
            'message' => $this->templating->render('ClubWelcomeBundle:Dashboard:blog_message.html.twig', array(
                'blog' => $b
            )),
            'link' => $this->router->generate('club_welcome_blog_show', array('blog_id' => $b->getId()))
        );

        $event->appendActivities($activity, $b->getCreatedAt()->format('U'));
    }
  }
}
