<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 16:26
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class Categories
{
    /**
* @ORM\Column(type="integer")
* @ORM\Id
* @ORM\GeneratedValue(strategy="AUTO")
*/
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}