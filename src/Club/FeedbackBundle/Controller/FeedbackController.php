<?php

namespace Club\FeedbackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedbackController extends Controller
{
  /**
   * @Route("/feedback/")
   * @Template()
   */
  public function indexAction()
  {
    $type = array(
      'idea' => $this->get('translator')->trans('Idea'),
      'bug' => $this->get('translator')->trans('Bug'),
      'other' => $this->get('translator')->trans('Other')
    );

    $form = $this->createFormBuilder()
      ->add('type','choice',array(
        'choices' => $type
      ))
      ->add('subject','text', array(
        'required' => true
      ))
      ->add('message','textarea')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $res = $form->getData();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message has been sent.'));

        return $this->redirect($this->generateUrl('club_feedback_feedback_index'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }
}
