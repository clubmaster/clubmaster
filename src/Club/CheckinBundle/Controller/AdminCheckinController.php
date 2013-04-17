<?php

namespace Club\CheckinBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/checkin")
 */
class AdminCheckinController extends Controller
{
    /**
     * @Route("/checkin/{user_id}")
     * @Template()
     */
    public function checkinAction($user_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->find('ClubUserBundle:User', $user_id);

        $checkin = new \Club\CheckinBundle\Entity\Checkin();
        $checkin->setUser($user);

        $em->persist($checkin);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'User has now checked in.');

        return $this->redirect($this->generateUrl('club_checkin_admincheckin_index'));
    }

    /**
     * @Route("", defaults={"page" = 1})
     * @Route("/{page}", name="club_checkin_admincheckin_offset")
     * @Template()
     */
    public function indexAction($page)
    {
        $results = 35;
        $em = $this->getDoctrine()->getManager();
        $paginator = $em->getRepository('ClubCheckinBundle:Checkin')->getPaginator($results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'club_checkin_admincheckin_offset');

        return array(
            'paginator' => $paginator
        );
    }
}
