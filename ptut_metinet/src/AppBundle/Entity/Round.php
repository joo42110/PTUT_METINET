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
use UserBundle\Entity\User;

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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="rounds")
     */

    private $referees;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="rounds")
     */

    private $fields;

    /**
     * @var string
     *
     * @ORM\Column(name="scheduled_time", type="string")
     */
    private $scheduledTime;

    /**
     * Round constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->fields = new ArrayCollection();
    }


    /**
     * @return Day
     */
    public function getDay()
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
    public function getScheduledTime()
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

    /**
     * @return ArrayCollection
     */
    public function getReferees()
    {
        return $this->referees;
    }

    /**
     * @param ArrayCollection $referees
     */
    public function setReferees(ArrayCollection $referees)
    {
        $this->referees = $referees;
    }

    /**
     * @param User $referee
     */
    public function addReferee(User $referee)
    {
        $this->referees->add($referee);
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

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fields->add($field);
    }











}