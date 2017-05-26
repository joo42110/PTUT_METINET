<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 25/05/2017
 * Time: 10:32 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="day")
 * Représente un jour lors duquel se déroule des mathces du tournoi
 */
class Day extends BaseEntity
{

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="days",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id",referencedColumnName="id")
     */
    private $tournament;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Round", mappedBy="days")
     */
    private $rounds;

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

    /**
     * @return ArrayCollection
     */
    public function getRounds(): ArrayCollection
    {
        return $this->rounds;
    }

    /**
     * @param ArrayCollection $rounds
     */
    public function setRounds(ArrayCollection $rounds)
    {
        $this->rounds = $rounds;
    }




}