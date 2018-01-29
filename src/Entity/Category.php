<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=190, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(name="cslug", type="string", length=190, unique=true)
     */
    private $cslug;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter $cslug
     *
     * @return string
     */
    public function getCslug()
    {
        return $this->cslug;
    }

    /**
     * Setter $slug
     *
     * @param string $cslug
     *
     * @return Category
     */
    public function setCslug($cslug)
    {
        $this->cslug = $cslug;

        return $this;
    }

    /**
     * This is Description of __toString
     *
     * @return string
     *
     */
    public function __toString()
    {
        return $this->name;
    }
}

