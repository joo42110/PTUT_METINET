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




}