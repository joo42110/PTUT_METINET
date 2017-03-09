<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 08/03/2017
 * Time: 15:04
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tournament")
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
     * Tournament constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->name = $name;
        $this->enabled = false;
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
     * @return bool
     */
    public function getEnabled():bool
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
    public function getTeamsNumber():int
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
    public function getPoolsNumber():int
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





}