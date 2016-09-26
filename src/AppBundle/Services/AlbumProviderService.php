<?php

namespace AppBundle\Services;
use AppBundle\Entity\Album;
use AppBundle\Entity\Image;
use AppBundle\Repositories\AlbumRepository;
use AppBundle\Repositories\ImageRepository;
use AppBundle\Services\Exception\AlbumNotFoundException;
use Doctrine\ORM\EntityManager;

/**
 * @author Vladislav Iavorskii
 */
class AlbumProviderService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var integer
     */
    private $imagesPerPage;

    /**
     * AlbumProviderService constructor.
     * @param $imagesPerPage
     * @param EntityManager $entityManager
     */
    public function __construct($imagesPerPage, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imagesPerPage = $imagesPerPage;
    }

    public function getAlbumImages($albumId, $page)
    {
        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->entityManager->getRepository(Album::class);
        /** @var Album|null $album */
        $album = $albumRepository->findOneBy(['id' => $albumId]);

        if (!empty($album)) {
            /** @var ImageRepository $imageRepository */
            $imageRepository = $this->entityManager->getRepository(Image::class);
            $images = $imageRepository->getImages($album, $page, $this->imagesPerPage);
        } else {
            throw new AlbumNotFoundException("Album {$albumId} isn't found");
        }

        return $images;
    }

    public function getAlbums()
    {
        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->entityManager->getRepository(Album::class);
        $albums = $albumRepository->findAll();

        return $albums;
    }

    /**
     * @param $id
     * @return null|Album
     */
    public function getAlbum($id)
    {
        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->entityManager->getRepository(Album::class);
        $album = $albumRepository->findOneBy(["id" => $id]);

        return $album;
    }

    public function getAlbumPagination(Album $album, $page)
    {
        $imageRepository = $this->entityManager->getRepository(Image::class);
        $qb = $imageRepository->createQueryBuilder('im');
        $qb->select($qb->expr()->count('im'))
            ->where("im.album = :album")
            ->setParameter("album", $album);
        $query = $qb->getQuery();
        $imageCount = $query->getSingleScalarResult();

        $numberOfPages = floor($imageCount/$this->imagesPerPage) + ceil(fmod($imageCount/$this->imagesPerPage, 1));
        return ['pages' => range(1, $numberOfPages), 'currentPage' => $page, 'albumId' => $album->getId()];
    }
}