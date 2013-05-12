<?php

namespace Club\ExchangeBundle\Listener;

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
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->security_context = $container->get('security.context');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
    }

    public function onMemberView(\Club\UserBundle\Event\FilterActivityEvent $event)
    {
        $exchanges = $this->em->getRepository('ClubExchangeBundle:Exchange')->findBy(
            array('user' => $event->getUser()->getId()),
            array('id' => 'DESC'),
            10
        );

        foreach ($exchanges as $e) {
            $activity = array(
                'date' => $e->getCreatedAt(),
                'type' => 'bundles/clublayout/images/icons/16x16/connect.png',
                'message' => $this->templating->render('ClubExchangeBundle:Dashboard:exchange_message.html.twig', array(
                    'exchange' => $e
                )),
                'link' => $this->router->generate('club_exchange_comment_index', array('id' => $e->getId()))
            );

            $event->appendActivities($activity, $e->getCreatedAt()->format('U'));
        }
    }

    public function onDashboardComing(\Club\UserBundle\Event\FilterActivityEvent $event)
    {
        $exchanges = $this->em->getRepository('ClubExchangeBundle:Exchange')->getComing();

        foreach ($exchanges as $e) {
            $activity = array(
                'date' => $e->getPlayTime(),
                'type' => 'bundles/clublayout/images/icons/16x16/connect.png',
                'message' => $this->templating->render('ClubExchangeBundle:Dashboard:exchange_message.html.twig', array(
                    'exchange' => $e
                )),
                'link' => $this->router->generate('club_exchange_comment_index', array('id' => $e->getId()))
            );

            $event->appendActivities($activity, $e->getPlayTime()->format('U'));
        }
    }
}
