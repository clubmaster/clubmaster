<?php

namespace Club\MatchBundle\Listener;

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

    public function onMemberView(\Club\UserBundle\Event\FilterActivityEvent $event)
    {
        $user = $event->getUser();

        $matches = $this->em->getRepository('ClubMatchBundle:Match')->getLatest($user);
        if (!$matches) return;

        foreach ($matches as $m) {

            $activity = array(
                'date' => $m->getCreatedAt(),
                'type' => 'bundles/clublayout/images/icons/16x16/medal_gold_1.png',
                'message' => $this->templating->render('ClubMatchBundle:Dashboard:match_message.html.twig', array(
                    'match' => $m

                )),
                'link' => $this->router->generate('club_match_match_show', array('id' => $m->getId()))
            );

            $event->appendActivities($activity, $m->getCreatedAt()->format('U'));
        }
    }

    public function onDashboardRecent(\Club\UserBundle\Event\FilterActivityEvent $event)
    {
        $connections = $this->em->getRepository('ClubUserBundle:Connection')->getDistinct($event->getUser());

        foreach ($connections as $conn) {
            $matches = $this->em->getRepository('ClubMatchBundle:Match')->getLatest($conn->getConnection());

	    if (is_array($matches)) {
		    foreach ($matches as $m) {

			    $activity = array(
				    'date' => $m->getCreatedAt(),
				    'type' => 'bundles/clublayout/images/icons/16x16/medal_gold_1.png',
				    'message' => $this->templating->render('ClubMatchBundle:Dashboard:match_message.html.twig', array(
					    'match' => $m

				    )),
				    'link' => $this->router->generate('club_match_match_show', array('id' => $m->getId()))
			    );

			    $event->appendActivities($activity, $m->getCreatedAt()->format('U'));
		    }
	    }
        }
    }
}
