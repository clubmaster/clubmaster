<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/ranking/match")
 */
class MatchController extends Controller
{
    /**
     * @Route("/new/{ranking_id}")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction($ranking_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $ranking = $em->find('ClubRankingBundle:Ranking', $ranking_id);

        $res = array();
        $res['user0'] = $this->getUser();

        $form = $this->get('club_match.match')->getMatchForm($res, $ranking->getGameSet());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                $this->get('club_match.match')->bindMatch($form->getData());
                $this->get('club_ranking.ranking')->validateMatch($ranking);

                if ($this->get('club_match.match')->isValid()) {
                    $this->get('club_match.match')->save();

                    $ranking->addMatch($this->get('club_match.match')->getMatch());

                    $em->persist($ranking);
                    $em->flush();
                    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

                    return $this->redirect($this->generateUrl('club_ranking_ranking_index'));
                } else {
                    $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
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
