<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 18/05/2017
 * Time: 11:26 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Représente un créneau horaire sur lequel peut se dérouler des matchs
 *
 * Class Round
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="round")
 *
 */
class Round extends BaseEntity
{

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="rounds",cascade={"persist"})
     * @ORM\JoinColumn(name="tournament_id",referencedColumnName="id")
     */
    private $tournament;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="round")
     */
    private $matches;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="scheduled_time", type="datetime")
     */
    private $scheduledTime;

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
     * @return DateTime
     */
    public function getScheduledTime(): DateTime
    {
        return $this->scheduledTime;
    }

    /**
     * @param DateTime $scheduledTime
     */
    public function setScheduledTime(DateTime $scheduledTime)
    {
        $this->scheduledTime = $scheduledTime;
    }





}