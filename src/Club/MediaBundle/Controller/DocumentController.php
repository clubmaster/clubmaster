<?php

namespace Club\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Club\MediaBundle\Entity\Document;
use Club\MediaBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/admin/media/document")
 */
class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="admin_media_document")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ClubMediaBundle:Document')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Document entity.
     *
     * @Route("/", name="admin_media_document_create")
     * @Method("POST")
     * @Template("ClubMediaBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Document();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_media_document'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('admin_media_document_create'),
            'method' => 'POST',
        ));

        $form->add('save', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="admin_media_document_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Document();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Deletes a Document entity.
     *
     * @Route("/delete/{id}", name="admin_media_document_delete")
     */
    public function deleteAction(Request $request, Document $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_media_document'));
    }
}
