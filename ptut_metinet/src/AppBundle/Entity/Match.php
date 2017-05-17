<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:05
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="football_match")
 */
class Match extends BaseEntity
{

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Team", inversedBy="matches",cascade={"persist"},orphanRemoval=true)
     * @ORM\JoinTable(name="matches_teams")
     */
    private $teams;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="matches",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id",referencedColumnName="id")
     */
    private $tournament;

    public function addTeam(Team $team){
        $this->teams->add($team);
    }

    public function removeTeam(Team $team){
        $this->teams->removeElement($team);
    }

    /**
     * @return ArrayCollection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @return Tournament
     */
    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    



}