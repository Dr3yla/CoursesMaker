<?php

namespace Rotis\CourseMakerBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déjà pris (à la casse près)")
 */
class Equipe implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var boolean
     */
    private $valide;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var boolean
     */
    protected $isActive;

   
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categorie
     *
     * @param \Rotis\CourseMakerBundle\Entity\Categorie $categorie
     * @return Equipe
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     *
     * @return Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Set valide
     *
     * @param boolean $valide
     * @return Equipe
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    
        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean 
     */
    public function getValide()
    {
        return $this->valide;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $joueurs;

    /**
     * @var \Rotis\CourseMakerBundle\Entity\Course
     */
    protected $course;

    /**
     * @var \Rotis\CourseMakerBundle\Entity\Categorie
     */
    protected $categorie;

    /**
     * Set salt
     *
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
	    
        return $this;
    }

    /**
     * Get salt
     *
	* @return string
	*/
	    public function getSalt()
	    {
		return $this->salt;
	    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->valide = false;
    }
   
 
    /**
     * Get type
     * @return \Rotis\CourseMakerBundle\Entity\Type
     */
    public function getType()
    {
        var_dump($this->course);die;
        return $this->course->getType();
    }

    /**
     *
     * Set type
     * @param \Rotis\CourseMakerBundle\Entity\Type $type
     * @return Equipe
     */
    public function setType($type)
    {
        $this->getCourse()->setType($type);
        return $this;
    }


    /**
     * Add joueurs
     *
     * @param \Rotis\CourseMakerBundle\Entity\Joueur $joueurs
     * @return Equipe
     */
    public function addJoueur(\Rotis\CourseMakerBundle\Entity\Joueur $joueurs)
    {
        $this->joueurs[] = $joueurs;
    
        return $this;
    }

    /**
     * Remove joueurs
     *
     * @param \Rotis\CourseMakerBundle\Entity\Joueur $joueurs
     */
    public function removeJoueur(\Rotis\CourseMakerBundle\Entity\Joueur $joueurs)
    {
        $this->joueurs->removeElement($joueurs);
    }

    /**
     * Get joueurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    /**
     * Set course
     *
     * @param \Rotis\CourseMakerBundle\Entity\Course $course
     * @return Equipe
     */
    public function setCourse(\Rotis\CourseMakerBundle\Entity\Course $course)
    {
        $this->course = $course;
        return $this;
    }

    /**
     * Get course
     *
     * @return \Rotis\CourseMakerBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Equipe
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set Password
     *
     * @param string $password
     * @return Equipe
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
    return $this->username === $user->getUsername();
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
}
