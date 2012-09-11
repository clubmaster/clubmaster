<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/booking/overview")
 */
class OverviewController extends Controller
{
   /**
    * @Template()
    * @Route("/{date}/{interval_id}")
    */
   public function viewAction($date, $interval_id)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);
     $interval = $this->get('club_booking.interval')->getVirtualInterval($interval, $date);

     $active = false;
     if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
       $subs = $em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($this->get('security.context')->getToken()->getUser(), null, 'booking', null, $interval->getField()->getLocation());
       $active = (!$subs) ? false : true;
     }

     return array(
       'interval' => $interval,
       'date' => $date,
       'form' => $form->createView(),
       'active' => $active
     );
   }

  /**
   * @Template()
   * @Route("/{date}", defaults={"date" = null})
   */
   public function indexAction($date)
   {
     $date = ($date == null) ? new \DateTime() : new \DateTime($date);
     $em = $this->getDoctrine()->getEntityManager();

     $nav = $this->getNav();
     $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
     $fields = $em->getRepository('ClubBookingBundle:Field')->findBy(array(
       'location' => $location->getId()
     ));

     if (!count($fields))

       return $this->redirect($this->generateUrl('club_booking_location_index'));

     return $this->render('ClubBookingBundle:Overview:'.$this->container->getParameter('club_booking.booking_style').'.html.twig', array(
       'date' => $date,
       'nav' => $nav,
       'location' => $location,
     ));
   }

   protected function getNav()
   {
     $nav = array();
     $d = new \DateTime();
     $i = new \DateInterval('P1D');
     $p = new \DatePeriod($d, $i, 6);
     foreach ($p as $dt) {
       $nav[] = $dt;
     }

     return $nav;
   }
}
