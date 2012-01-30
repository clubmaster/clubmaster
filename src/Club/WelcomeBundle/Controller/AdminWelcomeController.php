<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminWelcomeController extends Controller
{
  /**
   * @Route("/welcome/edit/{location_id}")
   * @Template()
   */
  public function editAction($location_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $welcome = $em->getRepository('ClubWelcomeBundle:Welcome')->findOneBy(array(
      'location' => $location_id
    ));

    if (!$welcome) {
      $location = $em->find('ClubUserBundle:Location', $location_id);

      $welcome = new \Club\WelcomeBundle\Entity\Welcome();
      $welcome->setLocation($location);
    }

    $res = $this->process($welcome);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'welcome' => $welcome,
      'form' => $res->createView()
    );
  }

  protected function process($welcome)
  {
    $form = $this->createForm(new \Club\WelcomeBundle\Form\Welcome(), $welcome);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($welcome);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_welcome_adminwelcome_edit', array(
          'location_id' => $welcome->getLocation()->getId()
        )));
      }
    }

    return $form;
  }
}
