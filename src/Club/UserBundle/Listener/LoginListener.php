<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    protected $container;
    protected $em;
    protected $security_context;
    protected $session;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->security_context = $container->get('security.context');
        $this->session = $container->get('session');
        $this->requestStack = $container->get('request_stack');
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->em->find('ClubUserBundle:User', $this->security_context->getToken()->getUser()->getId());
        $user->setLastLoginTime(new \DateTime());
        $user->setLastLoginIp($event->getRequest()->getClientIp());

        if (!strlen($user->getApiHash())) {
            $user->setApiHash($user->generateKey());
        }

        $this->em->persist($user);

        $login = new \Club\UserBundle\Entity\LoginAttempt();
        $login->setUsername($user->getUsername());
        $login->setSession(session_id());
        $login->setIpAddress($event->getRequest()->getClientIp());
        $login->setHostname(gethostbyaddr($event->getRequest()->getClientIp()));
        $login->setLoginFailed(0);

        $this->em->persist($login);
        $this->em->flush();

        $this->setLocation($event);
        $this->setLocale($event);
        $this->checkin($event);

        $reset = $this->em->createQueryBuilder()
            ->select('r')
            ->from('ClubUserBundle:ResetPassword', 'r')
            ->where('r.user = :user')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function setLocale($event)
    {
        $user = $this->security_context->getToken()->getUser();
        $s = $this->em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
            'user' => $user->getId(),
            'attribute' => 'language'
        ));

        if ($s) $event->getRequest()->setLocale($s->getValue());
    }

    private function setLocation($event)
    {
        if ($this->session->get('location_id')) return;

        $this->location = $this->em->getRepository('ClubUserBundle:Location')->getFirstLocation();
        if (!$this->location) return;

        $this->session->set('location_id', $this->location->getId());
        $this->session->set('location_name', $this->location->getLocationName());

        if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))

            return;

        $user = $this->em->find('ClubUserBundle:User', $this->security_context->getToken()->getUser()->getId());

        if ($user instanceOf \Club\UserBundle\Entity\User) {
            $user->setLocation($this->location);
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    private function checkin($event)
    {
        $allowed_ip = $this->container->getParameter('club_checkin.allowed_ip');

        foreach ($allowed_ip as $ip) {
            if ($ip == $event->getRequest()->getClientIp()) {
                $this->container->get('club_checkin.checkin')->checkin();
            }
        }
    }
}
