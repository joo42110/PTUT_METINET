<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 19/05/2017
 * Time: 12:53 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="field")
 */
class Field extends BaseEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name",type="string")
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="field")
     */
    private $matches;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="fields",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id",referencedColumnName="id")
     */
    private $tournament;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Round", inversedBy="referees")
     * @ORM\JoinTable(name="field_rounds")
     */
    private $rounds;

    /**
     * Field constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->rounds = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
    public function setMatches(ArrayCollection $matches)
    {
        $this->matches = $matches;
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
     * @param Round $round
     */
    public function addRound(Round $round)
    {
        $this->rounds->add($round);
        $round->addField($this);
    }





}