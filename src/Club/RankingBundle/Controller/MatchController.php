<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/ranking/match")
 */
class MatchController extends Controller
{
    /**
     * @Route("/new/{ranking_id}")
     * @Template()
     */
    public function newAction($ranking_id)
    {

        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $ranking = $em->find('ClubRankingBundle:Ranking', $ranking_id);

        $res = array();
        $res['user0'] = $this->getUser();

        $form = $this->get('club_match.match')->getMatchForm($res, $ranking->getGameSet());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                $this->get('club_match.match')->bindMatch($form->getData());
                $this->get('club_ranking.ranking')->validateMatch($ranking, $this->get('club_match.match'));

                if ($this->get('club_match.match')->isValid()) {
                    $rm = new \Club\RankingBundle\Entity\Match();
                    $rm->setRanking($ranking);
                    $rm->setMatch($this->get('club_match.match')->getMatch());

                    $ranking->addMatch($rm);

                    $this->get('club_match.match')->save();
                    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

                    return $this->redirect($this->generateUrl('club_ranking_ranking_show', array(
                        'id' => $ranking->getId()
                    )));
                } else {
                    $this->get('session')->getFlashBag()->add('error', $this->get('club_match.match')->getError());
                }
            }
        }

        return array(
            'form' => $form->createView(),
            'ranking' => $ranking,
            'sets' => $ranking->getGameSet()
        );
    }
}
