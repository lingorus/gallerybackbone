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
        $offset = $imagesPerPage * ($page - 1);
        return $this->findBy(['album' => $album], null, $imagesPerPage, $offset);
    }
}