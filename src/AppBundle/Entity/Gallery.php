<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Gallery")
 * @author Vladislav Iavorskii
 */
class Gallery
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column(name="title" , type="string")
     * @var string
     */
    protected $title;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="gallery", cascade={"persist", "remove"})
     * @var Image[]
     */
    protected $pictures;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Gallery
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Image[]
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param $pictures
     * @return $this
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
        return $this;
    }
}