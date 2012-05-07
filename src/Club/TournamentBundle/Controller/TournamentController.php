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
        'round' => 0,
        'name' => 'First round',
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => 3
            ),
            array(
              'name' => 'Poul Larsen',
              'result' => 1
            )
          ),
          array(
            array(
              'name' => 'Kresten Kjeldsen',
              'result' => 1
            ),
            array(
              'name' => 'Lars Johannesen',
              'result' => 3
            )
          ),
          array(
            array(
              'name' => 'Rikke Jensen',
              'result' => 3
            ),
            array(
              'name' => 'Mona Larsen',
              'result' => 1
            )
          ),
          array(
            array(
              'name' => 'Lonni Petersen',
              'result' => 1
            ),
            array(
              'name' => 'Henrik Hansen',
              'result' => 3
            )
          ),
        ),
      ),
      array(
        'name' => 'Semi final',
        'round' => 1,
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => 3
            ),
            array(
              'name' => 'Lars Johannesen',
              'result' => 1
            )
          ),
          array(
            array(
              'name' => 'Rikke Jsensen',
              'result' => 3
            ),
            array(
              'name' => 'Henrik Hansen',
              'result' => 1
            )
          ),
        ),
      ),
      array(
        'name' => 'Final',
        'round' => 2,
        'matches' => array(
          array(
            array(
              'name' => 'Michael Holm',
              'result' => -1
            ),
            array(
              'name' => 'Rikke Jensen',
              'result' => -1
            )
          )
        )
      )
    );

    return array(
      'tournament' => $tournament
    );
  }
}
