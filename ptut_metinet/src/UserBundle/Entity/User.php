<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Match;
use AppBundle\Entity\Round;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 * @UniqueEntity(fields="mail", message="Cet adresse email est déjà utilisée")
 */
class User extends BaseEntity implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\Email(
     *     message = "L'adresse '{{ value }}' est invalide.",
     *     checkMX = true
     * )
     */
    private $mail;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Votre mot de passe doit posseder au moins {{ limit }} caractères",
     * )
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     *
     */
    private $phone;
    
  
    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Match", mappedBy="referee")
     */
    private $arbitratedMatches;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Round", inversedBy="referees")
     * @ORM\JoinTable(name="referee_rounds")
     */
    private $rounds;


    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }
    
    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
    }
    
    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
        
    }

    
    /**
     * Set roles
     *
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
  
    
    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    public function hasRole($role)
    {
        if (in_array($role, $this->roles)) {
            return true;
        }
        return false;
    }
    
    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    
    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getPrintableName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
    
    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    
    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
    
    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    
    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return ArrayCollection
     */
    public function getArbitratedMatches()
    {
        return $this->arbitratedMatches;
    }

    /**
     * @param ArrayCollection $arbitratedMatches
     */
    public function setArbitratedMatches(ArrayCollection $arbitratedMatches)
    {
        $this->arbitratedMatches = $arbitratedMatches;
    }

    /**
     * @param Match $arbitratedMatch
     */
    public function addArbitratedMatches(Match $arbitratedMatch)
    {
        $this->arbitratedMatches->add($arbitratedMatch);
    }

    /**
     * @return ArrayCollection
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * @param ArrayCollection $rounds
     */
    public function setRounds(ArrayCollection $rounds)
    {
        $this->rounds = $rounds;
    }

    /**
     * @param Round $round
     */
    public function addRound(Round $round)
    {
        $this->rounds->add($round);
        $round->addReferee($this);
    }


    
    
    public function getSalt(){
        return null; //We use Bcrypt encoding so the salt is included in password hash
    }
    
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }
    
    /** @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

}
