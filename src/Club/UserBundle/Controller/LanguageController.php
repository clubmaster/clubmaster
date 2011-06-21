<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LanguageController extends Controller
{
  /**
   * @Template()
   * @Route("/language", name="admin_language")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $languages = $em->getRepository('\Club\UserBundle\Entity\Language')->findAll();

    return array(
      'languages' => $languages
    );
  }

  /**
   * @Route("/language/new", name="admin_language_new")
   * @Template()
   */
  public function newAction()
  {
    $language = new \Club\UserBundle\Entity\Language();
    $res = $this->process($language);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/language/edit/{id}", name="admin_language_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $language = $em->find('\Club\UserBundle\Entity\Language',$id);
    $res = $this->process($language);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView(),
      'language' => $language
    );
  }

  /**
   * @Route("/language/delete/{id}", name="admin_language_delete")
   * @Template()
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $language = $em->find('\Club\UserBundle\Entity\Language',$id);

    $em->remove($language);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_language'));
  }

  protected function process($language)
  {
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\Language(), $language);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($language);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_language'));
      }
    }

    return $form;
  }
}
