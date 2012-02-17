<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BlogController extends Controller
{
  /**
   * @Route("/welcome/blog/new")
   * @Template()
   */
  public function newAction()
  {
    $blog = new \Club\WelcomeBundle\Entity\Blog();
    $blog->setUser($this->get('security.context')->getToken()->getUser());

    $res = $this->process($blog);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/welcome/blog/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $blog = $em->find('ClubWelcomeBundle:Blog',$id);

    $res = $this->process($blog);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'blog' => $blog,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/welcome/blog/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getEntityManager();
      $blog = $em->find('ClubWelcomeBundle:Blog',$this->getRequest()->get('id'));

      $em->remove($blog);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete blog which is already being used.'));
    }

    return $this->redirect($this->generateUrl('homepage'));
  }

  protected function process($blog)
  {
    $form = $this->createForm(new \Club\WelcomeBundle\Form\Blog(), $blog);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($blog);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('homepage'));
      }
    }

    return $form;
  }
}
