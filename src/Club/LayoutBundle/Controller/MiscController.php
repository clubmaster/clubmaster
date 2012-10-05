<?php

namespace Club\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MiscController extends Controller
{
    public function searchAction()
    {
        $form = $this->createForm(new \Club\UserBundle\Form\Search());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $user = $form->get('user')->getData();
                return $this->redirect($this->generateUrl('club_user_adminuser_edit', array( 'id' => $user->getId() )));
            } else {
                $this->get('session')->setFlash('notice', 'No such user');
                return $this->redirect($this->generateUrl('club_user_adminuser_index'));
            }
        }

        return $this->render('ClubLayoutBundle:Default:search_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
