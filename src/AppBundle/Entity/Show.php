<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 16:25
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ShowRepository")
 * @ORM\Table(name="s_show")
 */
class Show
{
    const DATA_SOURCE_OMDB = 'OMDB';
    const DATA_SOURCE_DB = 'DB';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="euh ??", groups={"create","update"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create","update"})
     */
    private $abstract;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create","update"})
     */
    private $country;

    /**
     * @Assert\NotBlank(groups={"create","update"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shows")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     * @Assert\Image(minHeight=300, minWidth=750, groups={"create"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;

    /**
     * @ORM\Column
     */
    private $datasource;

    private $tmpimage;

    /**
     * @return mixed
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * @param mixed $datasource
     */
    public function setDatasource($datasource)
    {
        $this->datasource = $datasource;
    }



    /**
     * @return mixed
     */
    public function getTmpimage()
    {
        return $this->tmpimage;
    }

    /**
     * @param mixed $tmpimage
     */
    public function setTmpimage($tmpimage)
    {
        $this->tmpimage = $tmpimage;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param mixed $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



}