<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 13/05/2017
 * Time: 02:54 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="score")
 */
class Score extends BaseEntity
{
    /**
     * @var Team
     *
     * @ORM\OneToMany(targetEntity="Team", mappedBy="matches",cascade={"persist"},orphanRemoval=true)
     * @ORM\JoinTable(name="matches_teams")
     */
    private $team;



}