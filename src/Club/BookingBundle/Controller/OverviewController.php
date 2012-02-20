<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class OverviewController extends Controller
{
   /**
    * @Template()
    * @Route("/booking/{date}/{interval_id}")
    */
   public function viewAction($date, $interval_id)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new \Club\BookingBundle\Form\User());

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);
     $interval = $this->get('club_booking.interval')->getVirtualInterval($interval, $date);

     return array(
       'interval' => $interval,
       'date' => $date,
       'form' => $form->createView()
     );
   }

  /**
   * @Template()
   * @Route("/booking/{date}", defaults={"date" = null})
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

     if (!count($fields)) {
       $this->get('session')->setFlash('warning', $this->get('translator')->trans('There are no fields in this location, choose another location.'));
       $this->get('session')->set('switch_location', $this->generateUrl('club_booking_overview_index'));
       return $this->redirect($this->generateUrl('club_user_location_index'));
     }

     return array(
       'date' => $date,
       'nav' => $nav,
       'location' => $location
    );
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
