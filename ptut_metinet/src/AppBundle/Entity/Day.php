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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="day")
 *
 * Représente un jour lors duquel se déroule des mathces du tournoi
 */
class Day extends BaseEntity
{

    /**
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="days",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id",referencedColumnName="id")
     */
    private $tournament;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Round", mappedBy="day",cascade={"persist"},orphanRemoval=true)
     */
    private $rounds;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date",type="date")
     */
    private $date;

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
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return ArrayCollection
     */
    public function getRounds()
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

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getStringDate()
    {
        return $this->date->format('d/m/Y');
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }






}