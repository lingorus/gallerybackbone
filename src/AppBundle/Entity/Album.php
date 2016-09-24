<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\AlbumRepository")
 * @ORM\Table(name="Album")
 * @author Vladislav Iavorskii
 */
class Album
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="album", cascade={"persist", "remove"})
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
     * @return Album
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

    public function getFrontImage()
    {
        /** @var PersistentCollection $pictures */
        $pictures = $this->getPictures();
        if ($pictures->count()) {
            $slicedPictures = $pictures->slice(0, 1);
            $picture = reset($slicedPictures);
        } else {
            $picture = null;
        }

        return $picture;
    }

    public function getUrl()
    {
        return "url";
    }

    
}