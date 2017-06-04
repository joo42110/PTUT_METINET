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
 * @ORM\Table(name="cards")
 */
class Cards extends BaseEntity
{
    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="cards",cascade={"persist"})
     * @ORM\JoinColumn(name="team_id",referencedColumnName="id")
     */
    private $team;

    /**
     * @var Match
     *
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="cards",cascade={"persist"})
     * @ORM\JoinColumn(name="match_id",referencedColumnName="id")
     */
    private $match;

    /**
     * @var int
     *
     * @ORM\Column(name="yellow",type="integer")
     */
    private $yellow = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="red",type="integer")
     */
    private $red = 0;

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
    public function getYellow(): int
    {
        return $this->yellow;
    }

    /**
     * @param int $yellow
     */
    public function setYellow(int $yellow)
    {
        $this->yellow = $yellow;
    }

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * @param int $red
     */
    public function setRed(int $red)
    {
        $this->red = $red;
    }


    public function addYellow()
    {
        $this->yellow++;
    }

    public function removeYellow()
    {
        if($this->yellow > 0){
            $this->yellow--;
        }

    }

    public function addRed()
    {
        $this->red++;
    }

    public function removeRed()
    {
        if($this->red > 0){
            $this->red--;
        }

    }


}