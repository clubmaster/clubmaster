<?php

namespace Club\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/news")
 */
class AdminAnnouncementController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $announcements = $em->getRepository('ClubNewsBundle:Announcement')->findAll();

    return array(
      'announcements' => $announcements
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $start = new \DateTime(date('Y-m-d 00:00:00'));
    $end = clone $start;
    $i = new \DateInterval('P1M');
    $end->add($i);

    $user = $this->getUser();
    $announcement = new \Club\NewsBundle\Entity\Announcement();
    $announcement->setStartDate($start);
    $announcement->setEndDate($end);
    $announcement->setUser($user);

    $res = $this->process($announcement);

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
    $announcement = $em->find('ClubNewsBundle:Announcement',$id);

    $res = $this->process($announcement);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'announcement' => $announcement,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $announcement = $em->find('ClubNewsBundle:Announcement',$this->getRequest()->get('id'));

      $em->remove($announcement);
      $em->flush();

      $this->get('club_extra.flash')->addNotice();

    } catch (\PDOException $e) {
      $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You cannot delete announcement which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_news_adminannouncement_index'));
  }

  protected function process($announcement)
  {
    $form = $this->createForm(new \Club\NewsBundle\Form\Announcement(), $announcement);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($announcement);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_news_adminannouncement_index'));
      }
    }

    return $form;
  }
}
