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
use UserBundle\Entity\User;

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

    /**
     * @var Round
     *
     * @ORM\ManyToOne(targetEntity="Round", inversedBy="matches",cascade={"persist"})
     * @ORM\JoinColumn(name="round_id",referencedColumnName="id")
     */
    private $round;

    /**
     * @var Field
     *
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="matches",cascade={"persist"})
     * @ORM\JoinColumn(name="field_id",referencedColumnName="id")
     */
    private $field;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="arbitratedMatches",cascade={"persist"})
     * @ORM\JoinColumn(name="referee_id",referencedColumnName="id")
     */
    private $referee;

    /**
     * @ORM\Column(type="boolean")
     * Le match a-t-il été programmé ?
     */
    private $programed = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Score", mappedBy="match",cascade={"persist"},orphanRemoval=true)
     */
    private $scores;


    /**
     * Match constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }


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
     * @return Round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param Round $round
     */
    public function setRound(Round $round)
    {
        $this->round = $round;
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param Field $field
     */
    public function setField(Field $field)
    {
        $this->field = $field;
    }

    /**
     * @return User
     */
    public function getReferee()
    {
        return $this->referee;
    }

    /**
     * @param User $referee
     */
    public function setReferee(User $referee)
    {
        $this->referee = $referee;
    }

    /**
     * @return mixed
     */
    public function getProgramed()
    {
        return $this->programed;
    }

    /**
     * @param mixed $programed
     */
    public function setProgramed($programed)
    {
        $this->programed = $programed;
    }



    public function getName(){

        $name = '';
        $first = true;
        foreach($this->getTeams()->toArray() as $team){
            $name .= $team->getName();
            if($first){
              $name .= " vs ";
              $first = false;
            }
        }

        return $name;

    }

    /**
     * @return ArrayCollection
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param ArrayCollection $scores
     */
    public function setScores(ArrayCollection $scores)
    {
        $this->scores = $scores;
    }

    /**
     * @param Score $score
     */
    public function addScore(Score $score)
    {
        $this->scores->add($score);
        $score->setMatch($this);
    }







}