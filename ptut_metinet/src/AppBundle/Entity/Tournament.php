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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Field", mappedBy="tournament",cascade={"persist"},orphanRemoval=true)
     */
    private $fields;

    
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

    /**
     * @return ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param ArrayCollection $fields
     */
    public function setFields(ArrayCollection $fields)
    {
        $this->fields = $fields;
    }


    public function validate(){

        $errors = [];

        $registeredTeams = $this->getTeams()->count();

        //On verifie que le nombre d'équipes configurées dans le tournoi et le nombre d'équipes ajoutées correspondent
        if($registeredTeams !== $this->getTeamsNumber()){
            $errors[] = "Nombre d'équipes incorrect: le tournoi devrait comporter " . $this->getTeamsNumber() . " équipes mais " . $registeredTeams . " on été renseignées";
        }

        //On verifie que le tournoi a au moins un terrain
        if($this->getFields()->count() <= 0){
            $errors[] = "Aucun terrain n'a été ajouté. Vous devez ajouter au minimum 1 terrain";
        }

        //On valide également les équipes du tournoi
        foreach($this->getTeams()->toArray() as $team){
            $errors = array_merge($errors, $team->validate());
        }

        return $errors;

    }



    




}