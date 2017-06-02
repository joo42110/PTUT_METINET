<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:07
 */

namespace AppBundle\Entity;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pool")
 */
class Pool extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="pools",cascade={"all"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     *
     */
    private $tournament;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Team", mappedBy="pool",cascade={"persist"})
     *
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="Match",cascade={"persist"})
     * @ORM\JoinTable(name="pools_matches",
     *      joinColumns={@ORM\JoinColumn(name="pool_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $matches;


    /**
     * Pool constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param mixed $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    public function addTeam(Team $team){
        $this->teams->add($team);
        $team->setPool($this);
    }

    /**
     * @return mixed
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param mixed $matches
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;
    }

    public function addMatch(Match $match){
        $this->matches->add($match);
    }



    public function initialize(){

        $teams = $this->getTeams();
        // On crée les matches de la poules (chaque équipe joue contre toute les autres)

        /* Chaque équipe doit jouer une fois contre chaque autre équipe :
        On doit donc faire la liste des combinaisons uniques des équipes de la poule
        Pour celà on boucle sur chaque équipe, et on lui crée une combinaison (= un match) avec chaque équipe de la poule
        SAUF si :
        - Cette équipe est elle même
        - Cette équipe a déjà toute ses combinaisons réalisées (= cette équipe est passée dans une boucle précédente)

        Pour pouvoir tester la deuxième condition, on utilise un tableau contenant les IDs des équipes sur lesquelles on a déjà bouclé
        */

        $alreadyCombinedTeams = [];

        $tournament = $this->getTournament();

        //On boucle sur toute les équipes de la poule
        foreach($teams as $team){
            //On re-boucle sur les équipes pour constituer les combinaisons
            foreach($teams as $otherTeam){

                //Création du match
                if($team->getId() !== $otherTeam->getId() && !in_array($otherTeam->getId(),$alreadyCombinedTeams)){
                    $match = new Match();
                    $match->addTeam($team);
                    $match->addTeam($otherTeam);
                    //Création des scores
                    foreach($match->getTeams()->toArray() as $leTeam){
                        $score = new Score();
                        $score->setTeam($leTeam);
                        $match->addScore($score);
                    }
                    $this->addMatch($match);
                    $match->setTournament($tournament);
                }
            }

            $alreadyCombinedTeams[] = $team->getId();

        }
    }


    

}