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
     * @var Day
     *
     * @ORM\ManyToOne(targetEntity="Day", inversedBy="rounds",cascade={"persist"})
     * @ORM\JoinColumn(name="day_id",referencedColumnName="id")
     */
    private $day;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="round")
     */
    private $matches;

    /**
     * @var string
     *
     * @ORM\Column(name="scheduled_time", type="string")
     */
    private $scheduledTime;



    /**
     * @return Day
     */
    public function getDay(): Day
    {
        return $this->day;
    }

    /**
     * @param Day $day
     */
    public function setDay(Day $day)
    {
        $this->day = $day;
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
     * @return string
     */
    public function getScheduledTime(): string
    {
        return $this->scheduledTime;
    }

    /**
     * @param string $scheduledTime
     */
    public function setScheduledTime(string $scheduledTime)
    {
        $this->scheduledTime = $scheduledTime;
    }







}