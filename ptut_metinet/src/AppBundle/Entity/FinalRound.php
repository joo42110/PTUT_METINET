<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 06/06/2017
 * Time: 11:20
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="final_round")
 *
 * Représente un tour des phases finales
 */
class FinalRound extends BaseEntity
{
    const name = [
        2 => "Finale",
        4 => "Demi-finales" ,
        8 => "Quart de finales" ,
        16 => "Huitièmes de finales" ,
        32 => "Seizièmes de finales" ,
    ];

    public function getName(){
        return $this::name[$this->teamsNumber];
    }

    /**
     * @var int
     *
     * @ORM\Column(name="teams_number",type="integer")
     */
    private $teamsNumber;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="finalRounds",cascade={"all"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    private $tournament;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Match",cascade={"persist"})
     * @ORM\JoinTable(name="finals_matches",
     *      joinColumns={@ORM\JoinColumn(name="final_rounds_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="match_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $matches;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Team")
     * @ORM\JoinTable(name="final_round_teams",
     *      joinColumns={@ORM\JoinColumn(name="fianl_round_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     *      )
     */
    private $teams;


    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getTeamsNumber()
    {
        return $this->teamsNumber;
    }

    /**
     * @param int $teamsNumber
     */
    public function setTeamsNumber(int $teamsNumber)
    {
        $this->teamsNumber = $teamsNumber;
    }

    /**
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return ArrayCollection
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param ArrayCollection $matches
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;
    }

    /**
     * @param Match $match
     */
    public function addMatch($match)
    {
        $this->matches->add($match);
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

    /**
     * @param Team $team
     */
    public function addTeam(Team $team)
    {
        $this->teams->add($team);
    }

    public function initialize(){

        $teams = $this->getTeams()->toArray();
        shuffle($teams);

        $machups = array_chunk($teams,2);

        foreach($machups as $machup){
            //Création du match
            $match = new Match();
            foreach($machup as $team){
                $match->addTeam($team);
            }
            $match->initialize();
            $this->addMatch($match);
            $match->setTournament($this->tournament);
        }

    }





}