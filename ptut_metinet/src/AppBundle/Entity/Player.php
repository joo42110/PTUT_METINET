<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player extends BaseEntity
{

    /**
     * @ORM\Column(type="string")
     */
    private $licenceNumber;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $firstname;


    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="players")
     * @JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    /**
     * Player constructor.
     * @param string $licenceNumber
     * @param string $name
     * @param string $firstname
     */
    public function __construct(string $licenceNumber,string $name,string $firstname)
    {
        parent::__construct();
        $this->licenceNumber = $licenceNumber;
        $this->name = $name;
        $this->firstname = $firstname;
    }


    /**
     * @return string
     */
    public function getLicenceNumber():string
    {
        return $this->licenceNumber;
    }

    /**
     * @param string $licenceNumber
     */
    public function setLicenceNumber(string $licenceNumber)
    {
        $this->licenceNumber = $licenceNumber;
    }

    /**
     * @return string
     */
    public function getName():string
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
     * @return string
     */
    public function getFirstname():string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    


}