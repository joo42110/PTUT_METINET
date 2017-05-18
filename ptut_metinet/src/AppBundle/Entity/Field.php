<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 19/05/2017
 * Time: 12:53 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="field")
 */
class Field extends BaseEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name",type="string")
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Match", mappedBy="field")
     */
    private $matches;

    /**
     * @return string
     */
    public function getName(): string
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
     * @return ArrayCollection
     */
    public function getMatches(): ArrayCollection
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


}