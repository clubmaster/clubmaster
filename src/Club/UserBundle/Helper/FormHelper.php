<?php

namespace Club\UserBundle\Helper;

use Club\FormExtraBundle\Form\UserAjaxType;
use Doctrine\ORM\NonUniqueResultException;

class FormHelper
{
    protected $container;
    protected $em;
    protected $formFactory;
    protected $router;

    protected $form;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        $this->formFactory = $container->get('form.factory');
        $this->router = $container->get('router');
    }

    public function getAjaxForm($view=null, $action=null)
    {
        if ($action === null) {
            $action = $this->router->generate('club_user_member_search');
        }

        $user = new UserAjaxType(
            $this->router->generate('club_api_user_search'),
            $view
        );

        $this->form = $this->formFactory->create($user, null, array(
            'method' => 'POST',
            'action' => $action
        ));

        return $this->form;
    }

    public function getUser()
    {
        try {
            $data = $this->form->getData();

            if (is_numeric($data['user_id'])) {
                $user = $this->em->find('ClubUserBundle:User', $data['user_id']);

            } else {
                $user = $this->em->getRepository('ClubUserBundle:User')->getOneBySearch(
                    array(
                        'query' => $data['user']
                    ),
                    'u.id',
                    false
                );
            }

            if (!$user) {
                throw new \Exception('No such user');
            }

            return $user;

        } catch (NonUniqueResultException $e) {
            $this->container->get('club_extra.flash')->addError('Too many results.');

        } catch (\Exception $e) {
            $this->container->get('club_extra.flash')->addError('No match for this search.');
        }
    }
}
