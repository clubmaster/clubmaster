<?php

namespace Club\MailBundle\Listener;

class PasswordResetListener
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

    public function onPasswordReset(\Club\UserBundle\Event\FilterForgotPasswordEvent $event)
    {
        $user = $event->getForgotPassword()->getUser();
        $email = $user->getProfile()->getProfileEmail();

        if ($email) {
            $this->clubmaster_mailer
                ->init()
                ->setSpool(false)
                ->setSubject('Reset Password')
                ->setFrom()
                ->setTo($email->getEmailAddress())
                ->setBody($this->templating->render('ClubMailBundle:Template:password_reset.html.twig',array(
                    'user' => $user,
                    'url' => $this->router->generate(
                        'auth_reset',
                        array(
                            'hash' => $event->getForgotPassword()->getHash()
                        ),
                        true
                    )
                )))
                ->send();
        }
    }
}
