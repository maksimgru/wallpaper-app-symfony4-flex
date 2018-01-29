<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Model\FileInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Wallpaper
 *
 * @ORM\Table(name="wallpaper")
 * @ORM\Entity(repositoryClass="App\Repository\WallpaperRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Wallpaper
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Many Wallpapers are in One Category.
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=190, unique=false, nullable=true)
     */
    private $title;

    /**
     * @var FileInterface|null
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=190, unique=true)
     */
    private $filename;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"filename"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=190, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

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
     * Getter $category
     *
     * @return  Category|null
     *
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Setter $category
     *
     * @param Category $category
     *
     * @return Wallpaper
     *
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Getter $title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Setter $title
     *
     * @param string $title
     *
     * @return Wallpaper
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter $file
     *
     * @return FileInterface|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Setter $file
     *
     * @param FileInterface|null $file
     *
     * @return Wallpaper
     */
    public function setFile(FileInterface $file = null)
    {
        $this->file = $file;

        if ($file) {
            $this->setUpdatedAt();
        }

        return $this;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Wallpaper
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Wallpaper
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Wallpaper
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Wallpaper
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }


    /**
     * This is Description of getImage
     *
     * @return string
     */
    public function getImage()
    {
        return $this->filename;
    }

    /**
     * This is Description of __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->slug;
    }
}

