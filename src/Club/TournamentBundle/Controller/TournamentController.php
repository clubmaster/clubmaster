<?php

namespace Club\TournamentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/tournament")
 */
class TournamentController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $tournament = array(
      array(
        'round' => 1,
        'name' => 'First round',
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => '6-6'
            ),
            array(
              'name' => 'Poul Larsen',
              'result' => '4-4'
            )
          ),
          array(
            array(
              'name' => 'Kresten Kjeldsen',
              'result' => '1-1'
            ),
            array(
              'name' => 'Lars Johannesen',
              'result' => '6-6'
            )
          ),
          array(
            array(
              'name' => 'Rikke Jensen',
              'result' => '6-6'
            ),
            array(
              'name' => 'Mona Larsen',
              'result' => '1-1'
            )
          ),
          array(
            array(
              'name' => 'Lonni Petersen',
              'result' => '1-1'
            ),
            array(
              'name' => 'Henrik Hansen',
              'result' => '6-6'
            )
          ),
        ),
      ),
      array(
        'name' => 'Semi final',
        'round' => 2,
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => '6-6'
            ),
            array(
              'name' => 'Lars Johannesen',
              'result' => '0-0'
            )
          ),
          array(
            array(
              'name' => 'Rikke Jsensen',
              'result' => '6-6'
            ),
            array(
              'name' => 'Henrik Hansen',
              'result' => '1-1'
            )
          ),
        ),
      ),
      array(
        'name' => 'Final',
        'round' => 3,
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => '6-6'
            ),
            array(
              'name' => 'Rikke Jensen',
              'result' => '0-3'
            )
          )
        ),
      ),
      array(
        'name' => 'Champion',
        'round' => 4,
        'winner' => array(
          'name' => 'Michael Holm'
        )
      )
    );

    return array(
      'tournament' => $tournament
    );
  }
}
