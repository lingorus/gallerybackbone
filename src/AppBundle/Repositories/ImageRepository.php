<?php

namespace AppBundle\Repositories;

use AppBundle\Entity\Album;
use Doctrine\ORM\EntityRepository;

/**
 * @author Vladislav Iavorskii
 */
class ImageRepository extends EntityRepository
{
    /**
     * Get images for a specified page and album.
     *
     * @param Album $album
     * @param $page
     * @param $imagesPerPage
     * @return array
     */
    public function getImages(Album $album, $page, $imagesPerPage)
    {
        $offset = $imagesPerPage * ($page - 1);
        
        return $this->findBy(['album' => $album], null, $imagesPerPage, $offset);
    }

    /**
     * Get number of images in album.
     *
     * @param Album $album
     * @return mixed
     */
    public function getCount(Album $album)
    {
        $qb = $this->createQueryBuilder('im');
        $qb->select($qb->expr()->count('im'))
            ->where("im.album = :album")
            ->setParameter("album", $album);
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
}