<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/team/category")
 */
class AdminTeamCategoryController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('ClubTeamBundle:TeamCategory')->findAll();

    return array(
      'categories' => $categories
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $category = new \Club\TeamBundle\Entity\TeamCategory();

    $res = $this->process($category);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubTeamBundle:TeamCategory',$id);

    $res = $this->process($category);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'category' => $category,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubTeamBundle:TeamCategory',$this->getRequest()->get('id'));

    $em->remove($category);
    $em->flush();

    $this->get('club_extra.flash')->addNotice();

    return $this->redirect($this->generateUrl('club_team_adminteamcategory_index'));
  }

  protected function process($category)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\TeamCategory(), $category);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_team_adminteamcategory_index'));
      }
    }

    return $form;
  }
}
