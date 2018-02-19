<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     */
    private $fullname;

    private $roles;

    /**
     * @ORM\Column
     */
    private $password;

    /**
     * @ORM\Column
     * @Assert\Email
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
        return ['ROLE_ADMIN'];
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

    public function removeShow()
    {

    }
}