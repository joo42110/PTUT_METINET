<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:07
 */

namespace AppBundle\Entity;

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


    

}