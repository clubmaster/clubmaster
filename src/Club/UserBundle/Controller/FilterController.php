<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class FilterController extends Controller
{
    /**
     * @Route("/filter/quick")
     */
    public function quickAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new \Club\UserBundle\Form\Search());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $user = $form->get('user')->getData();
                return $this->redirect($this->generateUrl('admin_user_edit', array( 'id' => $user->getId() )));
            } else {
                foreach ($form->get('user')->getErrors() as $error) {
                    $this->get('session')->setFlash('error', $error->getMessage());
                }
            }
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }
}
