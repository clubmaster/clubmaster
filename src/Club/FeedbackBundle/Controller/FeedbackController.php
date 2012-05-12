<?php

namespace Club\FeedbackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/feedback")
 */
class FeedbackController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $type = array(
      'idea' => $this->get('translator')->trans('Idea'),
      'bug' => $this->get('translator')->trans('Bug'),
      'other' => $this->get('translator')->trans('Other')
    );

    $data = array();
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
      $user = $this->get('security.context')->getToken()->getUser();
      $data = array(
        'name' => $user->getProfile()->getName()
      );

      if ($user->getProfile()->getProfileEmail())
        $data['email'] = $user->getProfile()->getProfileEmail()->getEmailAddress();
    }
    $form = $this->createFormBuilder($data)
      ->add('name','text',array(
        'required' => false
      ))
      ->add('email','email',array(
        'required' => false
      ))
      ->add('type','choice',array(
        'choices' => $type
      ))
      ->add('subject','text',array(
        'required' => true
      ))
      ->add('message','textarea',array(
        'required' => true
      ))
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $data = $form->getData();
        $this->sendData($data);

        return $this->redirect($this->generateUrl('club_feedback_feedback_index'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }

  private function sendData(array $data)
  {
    $host = 'loopback.clubmaster.dk';
    $fp = @fsockopen($host,80);

    $data['host'] = $this->generateUrl('homepage', array(), true);
    $str = '';
    foreach ($data as $key=>$value) {
      $str .= $key.'='.$value.'&';
    }

    if ($fp) {
      fputs($fp, "POST /feedback HTTP/1.1\r\n");
      fputs($fp, "HOST: loopback.clubmaster.dk\r\n");
      fputs($fp, "User-Agent: ClubMasterTool 1.0\r\n");
      fputs($fp, "Content-length: ".strlen($str)."\r\n");
      fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n\r\n");

      fputs($fp, $str."\r\n\r\n");

      $res = '';
      while (!feof($fp)) $res .= fgets($fp,4096);
      fclose($fp);

      if (strpos($res,'200 OK')) {
        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message has been sent.'));
        return;
      }
    }

    $this->get('session')->setFlash('error',$this->get('translator')->trans('There was a problem delivering your message.'));
  }
}
