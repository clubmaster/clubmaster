<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/{_locale}/admin")
 */
class AdminWelcomeController extends Controller
{
  /**
   * @Route("/welcome")
   * @Template()
   */
  public function indexAction()
  {
    return $this->redirect($this->generateUrl('club_welcome_adminwelcome_edit', array('location_id' => 1)));
  }

  /**
   * @Route("/welcome/edit/{location_id}")
   * @Template()
   */
  public function editAction($location_id)
  {
    $em = $this->getDoctrine()->getManager();
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
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($welcome);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_welcome_adminwelcome_edit', array(
          'location_id' => $welcome->getLocation()->getId()
        )));
      }
    }

    return $form;
  }
}
