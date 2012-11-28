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
     * @Route("/interval/{date}")
     */
    public function intervalAction($date)
    {
        $request = $this->getRequest();

        $date = new \DateTime($date);
        $interval = $request->request->get('interval_id');

        return $this->redirect($this->generateUrl('club_booking_overview_view', array(
            'date' => $date->format('Y-m-d'),
            'id' => $interval
        )));
    }

    /**
     * @Template()
     * @Route("/{date}/{id}")
     */
    public function viewAction($date, \Club\BookingBundle\Entity\Interval $interval)
    {
        $date = new \DateTime($date);
        $interval = $this->get('club_booking.interval')->getVirtualInterval($interval, $date);

        $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());
        $em = $this->getDoctrine()->getEntityManager();
        $active = false;
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $subs = $em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($this->getUser(), null, 'booking', null, $interval->getField()->getLocation());
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
     * @Route("", name="club_booking_overview", defaults={"date" = null})
     * @Route("/{date}")
     */
    public function indexAction($date)
    {
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $date = new \DateTime($request->request->get('date'));
        } else {
            $date = ($date == null) ? new \DateTime() : new \DateTime($date);
        }
        $em = $this->getDoctrine()->getEntityManager();

        $nav = $this->getNav();
        $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
        $fields = $em->getRepository('ClubBookingBundle:Field')->findBy(array(
            'location' => $location->getId()
        ));

        if ($this->getUser() && $this->getUser()->getLocation() != $location) {
            $this->getUser()->setLocation($location);

            $em->persist($this->getUser());
            $em->flush();
        }

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
