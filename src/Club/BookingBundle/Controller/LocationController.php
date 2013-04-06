<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/booking/location")
 */
class LocationController extends Controller
{
    /**
     * @Template()
     * @Route("")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('ClubBookingBundle:Field')->getLocationWithFields();

        return array(
            'locations' => $locations
        );
    }

    /**
     * @Route("/{id}")
     */
    public function switchAction(\Club\UserBundle\Entity\Location $location)
    {
        $user = $this->getUser();

        $this->get('session')->set('location_id', $location->getId());
        $this->get('session')->set('location_name', $location->getLocationName());

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user->setLocation($location);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('club_booking_overview'));
    }
}
