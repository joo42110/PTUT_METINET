<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 06/06/2017
 * Time: 14:22
 *
 * STREERTUGHFARE
 *
 */

namespace AppBundle\Entity;

/**
 * Class PoolRanking
 *
 * représente les infos de classement d'une équipe durant les poules
 */
class PoolRanking
{

    /**
     * @var Team
     */
    private $team;

    /**
     * @var int
     */
    private $won = 0;

    /**
     * @var int
     */
    private $tie = 0;

    /**
     * @var int
     */
    private $lost = 0;

    /**
     * @var int
     */
    private $goalsScored = 0;

    /**
     * @var int
     */
    private $goalsTaken = 0;

    /**
     * @var int
     */
    private $goalDifference = 0;

    /**
     * @var int
     */
    private $points = 0;






    /**
     * PoolRanking constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
        $this->initialize();
    }

    private function initialize(){

        foreach($this->team->getMatches() as $match){

            if($match->isPlayed()){
                if(!$match->isTie()){ //Stats sur gagnés/perdus/nuls
                    if($match->getWinner() == $this->team){
                        $this->won++;
                    }
                    else{
                        $this->lost++;
                    }
                }
                else{
                    $this->tie++;
                }

                foreach($match->getScores() as $score){ //Stats sur buts pris/mis
                    if($score->getTeam() == $this->team){
                        $this->goalsScored += $score->getGoals();
                    }
                    else{
                        $this->goalsTaken += $score->getGoals();
                    }
                }
            }

        }

        $this->goalDifference = $this->goalsScored - $this->goalsTaken;

        /*  Règles pour les points
        *
         * Victoire = 4 points
         * Nul = 2 points
         * Defaite = 1 points
        */
        $this->points = ($this->won * 4) + ($this->tie * 2) + ($this->lost);

    }

    /**
     * Retourne 1 si ce classement est supérieur a 'lautre, -1 sinon
     */
    public function compareTo(PoolRanking $other){

        //Cas standard = départagement aux points
        if($this->points > $other->getPoints()){
            return 1;
        }
        else if($this->points < $other->getPoints()){
            return -1;
        }

        //Cas éqalité 1 : dépatagement au résultat du match entre les 2 équipes
        foreach($this->team->getMatches() as $match){
            if($match->getTeams()->contains($other->getTeam())){//Match entre les deux équipes
                if($match->getWinner() == $this->team){
                    return 1;
                }
                else{
                    return -1;
                }
            }
        }

        //Cas égalité 2: départagement au goal average général
        if($this->goalDifference > $other->getGoalDifference()){
            return 1;
        }
        else if($this->goalDifference < $other->getGoalDifference()){
            return -1;
        }

        //Cas d'égalité 3: meilleure attaque
        if($this->goalsScored > $other->getGoalsScored()){
            return 1;
        }
        else if($this->goalsScored < $other->getGoalsScored()){
            return -1;
        }

        //Cas d'égalité 4: meilleure défense
        if($this->goalsScored < $other->getGoalsScored()){ // /!\ ATTENTION : MOINS DE BUTS ENCAISSES = PLUS PETIT EST LE MEILLEUR
            return 1;
        }
        else if($this->goalsScored > $other->getGoalsScored()){
            return -1;
        }

        //Cas d'égalité 5: tirage au sort
        if(random_int(0,9) > 4){
            return 1;
        }
        else{
            return -1;
        }

    }


    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }


    /**
     * @return int
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * @return int
     */
    public function getTie()
    {
        return $this->tie;
    }

    /**
     * @return int
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * @return int
     */
    public function getGoalsScored()
    {
        return $this->goalsScored;
    }

    /**
     * @return int
     */
    public function getGoalsTaken()
    {
        return $this->goalsTaken;
    }

    /**
     * @return int
     */
    public function getGoalDifference()
    {
        return $this->goalDifference;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }



}