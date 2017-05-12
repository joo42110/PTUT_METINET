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
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="players",cascade={"persist"})
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $team;



    /**
     * Player constructor.
     *
     * @param string $name
     * @param string $firstname
     * @param string $licenceNumber
     */
   /* public function __construct(string $name=null,string $firstname=null,string $licenceNumber=null)
    {
        parent::__construct();

        $this->name = $name;
        $this->name = $firstname;
        $this->name = $licenceNumber;
    }*/


    /**
     * @return string|null
     */
    public function getLicenceNumber()
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
     * @return string|null
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
     * @return string|null
     */
    public function getFirstname()
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

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }






    


}