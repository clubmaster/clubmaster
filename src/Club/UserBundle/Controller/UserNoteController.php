<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserNoteController extends Controller
{
  /**
   * @Route("/user_note/{id}", name="admin_user_note")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $user_notes = $em->getRepository('ClubUserBundle:UserNote')->findBy(array(
      'user' => $user->getId()
    ));

    return $this->render('ClubUserBundle:UserNote:index.html.twig',array(
      'user' => $user,
      'user_notes' => $user_notes
    ));
  }

  /**
   * @Route("/user_note/new/{id}", name="admin_user_note_new")
   * @Template()
   */
  public function newAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    $user_note = new \Club\UserBundle\Entity\UserNote();
    $user_note->setUser($user);

    $res = $this->process($user_note);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'user' => $user,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/user_note/edit/{id}", name="admin_user_note_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user_note = $em->find('ClubUserBundle:UserNote',$id);
    $res = $this->process($user_note);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'user_note' => $user_note,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/user_note/delete/{id}", name="admin_user_note_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user_note = $em->find('ClubUserBundle:UserNote',$id);

    $em->remove($user_note);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_user_note',array(
      'id' => $user_note->getUser()->getId()
    )));
  }

  protected function process($user_note)
  {
    $form = $this->createForm(new \Club\UserBundle\Form\UserNote(), $user_note);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user_note);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_user_note', array(
          'id' => $user_note->getUser()->getId()
        )));
      }
    }

    return $form;
  }
}
