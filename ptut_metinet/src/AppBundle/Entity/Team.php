<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:04
 */

namespace AppBundle\Entity;



use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Team")
 */
class Team extends BaseEntity

{

    /**
     * @ORM\Column(type="string")
     */
    private $name;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Player", mappedBy="team",cascade={"persist"},orphanRemoval=true)
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="teams",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="Pool", inversedBy="teams",cascade={"persist"})
     * @ORM\JoinColumn(name="pool_id", referencedColumnName="id")
     *
     */
    private $pool;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Match", mappedBy="teams",cascade={"persist"},orphanRemoval=true)
     */
    private $matches;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Score", mappedBy="team",cascade={"persist"},orphanRemoval=true)
     */
    private $scores;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Cards", mappedBy="team",cascade={"persist"},orphanRemoval=true)
     */
    private $cards;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param mixed $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

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
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param mixed $pool
     */
    public function setPool($pool)
    {
        $this->pool = $pool;
    }


    public function validate(){
        $errors = [];

        if($this->getPlayers()->count() < 10){
            $errors[] = "L'équipe " . $this->getName() . " contient moins de 10 joueurs";
        }

        return $errors;
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
        $score->setTeam($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param ArrayCollection $cards
     */
    public function setCards(ArrayCollection $cards)
    {
        $this->cards = $cards;
    }

    /**
     * @param Cards $cards
     */
    public function addCards(Cards $cards)
    {
        $this->cards->add($cards);
        $cards->setTeam($this);
    }

    public function getPlayedMatchOrdered(){

        $playedMatchesCallback = function($match){
            return $match->isPlayed();
        };

        $playedMatches = $this->matches->filter($playedMatchesCallback);

        $orderMatchesCallback = function($a,$b){
            //Classement par match plus récent
          if($a->getMatchEndTime() > $b->getMatchEndTime()){
              return -1;
          }
          else{
              return 1;
          }
        };
        $orderedMatches = $playedMatches->toArray();
         usort($orderedMatches,$orderMatchesCallback);
        return $orderedMatches;

    }

    public function getLastPlayedMatch(){

        return $this->getPlayedMatchOrdered()[0];

    }












}