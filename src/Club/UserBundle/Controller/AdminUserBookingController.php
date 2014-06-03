<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\User;

/**
 * @Route("/{_locale}/admin/user/booking")
 */
class AdminUserBookingController extends Controller
{
    /**
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime();
        $bookings = $em->getRepository('ClubBookingBundle:Booking')->getAllFutureBookings($user, $date);

        return array(
            'user' => $user,
            'bookings' => $bookings
        );
    }
}
