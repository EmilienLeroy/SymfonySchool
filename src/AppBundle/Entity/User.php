<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity("email")
 * @JMS\ExclusionPolicy("all")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     * @JMS\Expose
     * @JMS\Groups({"user", "show"})
     */
    private $fullname;

    /**
     * @ORM\Column(type="json_array")
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"user_create"})
     */
    private $roles;

    /**
     * @ORM\Column
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $password;

    /**
     * @ORM\Column
     * @Assert\Email
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Show", mappedBy="author")
     */
    private $shows;


    public function __construct()
    {
        $this->shows = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
       return $this->password;
    }

    public function setPassword($pass)
    {
        $this->password = $pass;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function setUsername($email)
    {
        $this->email = $email;
    }

    public function addShow(Show $show)
    {
        if(!$this->shows->contains($show)) $this->shows->add($show);
    }

    public function getShows()
    {
        return $this->shows;
    }

    public function removeShow(Show $show)
    {
        $this->shows->remove($show);
    }

    public function updateUser(User $user)
    {
        if($user->getFullname() != null) $this->fullname = $user->getFullname();
        if($user->getUsername() != null) $this->email = $user->getUsername();
        if($user->getPassword() != null) $this->password = $user->getPassword();
    }
}