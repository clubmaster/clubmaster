<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Club\UserBundle\Entity\User;
use Club\MediaBundle\Entity\Document;
use Club\MediaBundle\Form\DocumentType;

/**
 * @Route("/{_locale}/admin/user/document")
 */
class AdminUserDocumentController extends Controller
{
    /**
     * @Route("/{id}", name="admin_user_document")
     * @Template()
     */
    public function indexAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ClubMediaBundle:Document')->findBy(array(
            'user' => $user
        ));

        return array(
            'user' => $user,
            'entities' => $entities
        );
    }

    /**
     * @Route("/{id}/new", name="admin_user_document_new")
     * @Template()
     */
    public function newAction(Request $request, User $user)
    {
        $document = new Document();
        $document->setUser($user);

        $form = $this->createForm(new DocumentType(), $document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);

            $em->flush();

            return $this->redirect($this->generateUrl('admin_user_document', array(
                'id' => $user->getId()
            )));
        }

        return array(
            'user' => $user,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{user_id}/delete/{id}", name="admin_user_document_delete")
     */
    public function deleteAction($user_id, Document $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_user_document',array(
            'id' => $user_id
        )));
    }
}
