<?php

namespace Club\MailBundle\Listener;

class ExchangeComment
{
    protected $container;
    protected $em;
    protected $templating;
    protected $router;
    protected $clubmaster_mailer;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
        $this->clubmaster_mailer = $container->get('clubmaster_mailer');
    }

    public function onExchangeCommentNew(\Club\ExchangeBundle\Event\FilterExchangeCommentEvent $event)
    {
        $users = $this->em->getRepository('ClubExchangeBundle:Exchange')->getUsers($event->getExchangeComment()->getExchange());
        unset($users[$event->getUser()->getId()]);

        $this->clubmaster_mailer
            ->setSubject('Exchange comment')
            ->setDecorator($users)
            ->setFrom()
            ->setBody($this->templating->render('ClubMailBundle:Template:exchange_comment.html.twig',array(
                'comment' => $event->getExchangeComment()
            )));

        foreach ($users as $user) {
            if ($user->getEmail()) {
                $this->clubmaster_mailer
                    ->setTo($user->getEmail())
                    ->send();
            }
        }
    }
}
