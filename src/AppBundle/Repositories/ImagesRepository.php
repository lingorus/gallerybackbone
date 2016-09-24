<?php

namespace AppBundle\Repositories;

use AppBundle\Entity\Album;
use Doctrine\ORM\EntityRepository;

/**
 * @author Vladislav Iavorskii
 */
class ImageRepository extends EntityRepository
{
    public function getImages(Album $album, $page, $imagesPerPage)
    {
        $offset = ($imagesPerPage - 1) * $page;
        return $this->findBy(['gallery' => $album, null, $imagesPerPage, $offset]);
    }
}