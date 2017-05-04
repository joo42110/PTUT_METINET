<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 04/05/2017
 * Time: 16:30
 */

namespace AppBundle;


use AppBundle\Entity\Tournament;

class TournamentValidator
{
    /**
     * @param Tournament $tournament
     */
    public function validate(Tournament $tournament){

        $errors = array();

        $teamsNumber = $tournament->getTeams()->count();

        if($teamsNumber != $tournament->getTeamsNumber()){
            $errors[] = "Le nombre d'équipes renseignées est incorrect";
        }


    }

}