<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:04
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="tournament")
 * @UniqueEntity(fields="name", message="Ce nom est déjà utilisé")
 */
class Tournament extends BaseEntity
{

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamsNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $poolsNumber;



    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Team", mappedBy="tournament",cascade={"persist"},orphanRemoval=true)
     */
    private $teams;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Pool", mappedBy="tournament",cascade={"persist"})
     */
    private $pools;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamsOutOfPools;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="tournament")
     */
    private $matches;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Round", mappedBy="tournament")
     */
    private $rounds;

    
    /**
     * Tournament constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->enabled = false;
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
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
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
     * @return int
     */
    public function getPoolsNumber()
    {
        return $this->poolsNumber;
    }

    /**
     * @param int $poolsNumber
     */
    public function setPoolsNumber(int $poolsNumber)
    {
        $this->poolsNumber = $poolsNumber;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param ArrayCollection $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return ArrayCollection
     */
    public function getPools()
    {
        return $this->pools;
    }

    /**
     * @param ArrayCollection $pools
     */
    public function setPools($pools)
    {
        $this->pools = $pools;
    }

    /**
     * @return mixed
     */
    public function getTeamsOutOfPools()
    {
        return $this->teamsOutOfPools;
    }

    /**
     * @param mixed $teamsOutOfPools
     */
    public function setTeamsOutOfPools($teamsOutOfPools)
    {
        $this->teamsOutOfPools = $teamsOutOfPools;
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