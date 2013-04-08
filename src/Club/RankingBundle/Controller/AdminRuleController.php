<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/ranking/rule")
 */
class AdminRuleController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $rules = $em->getRepository('ClubRankingBundle:Rule')->findAll();

    return array(
      'rules' => $rules
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $rule = new \Club\RankingBundle\Entity\Rule();
    $rule->setPointWon(2);
    $rule->setPointLost(0);
    $rule->setSamePlayer(2);

    $res = $this->process($rule);

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
    $rule = $em->find('ClubRankingBundle:Rule',$id);

    $res = $this->process($rule);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'rule' => $rule,
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
      $rule = $em->find('ClubRankingBundle:Rule',$this->getRequest()->get('id'));

      $em->remove($rule);
      $em->flush();

      $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You cannot delete rule which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_ranking_adminrule_index'));
  }

  protected function process($rule)
  {
    $form = $this->createForm(new \Club\RankingBundle\Form\Rule(), $rule);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($rule);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_ranking_adminrule_index'));
      }
    }

    return $form;
  }
}
