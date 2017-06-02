<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 13/05/2017
 * Time: 02:54 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="score")
 */
class Score extends BaseEntity
{
    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="scores",cascade={"persist"})
     * @ORM\JoinColumn(name="team_id",referencedColumnName="id")
     */
    private $team;

    /**
     * @var Match
     *
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="scores",cascade={"persist"})
     * @ORM\JoinColumn(name="match_id",referencedColumnName="id")
     */
    private $match;

    /**
     * @var int
     *
     * @ORM\Column(name="goals",type="integer")
     */
    private $goals = 0;

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param Match $match
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;
    }

    /**
     * @return int
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @param int $goals
     */
    public function setGoals(int $goals)
    {
        $this->goals = $goals;
    }

    public function addGoal()
    {
        $this->goals++;
    }

    public function removeGoal()
    {
        if($this->goals > 0){
            $this->goals--;
        }

    }


}