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
    public function __construct($imagesPerPage, $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imagesPerPage = $imagesPerPage;
    }

    /**
     * Get images by album.
     *
     * @param $albumId
     * @param $page
     * @return array
     * @throws AlbumNotFoundException
     */
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

    /**
     * Ger list of albums
     *
     * @return array
     */
    public function getAlbums()
    {
        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->entityManager->getRepository(Album::class);
        $albums = $albumRepository->findAll();

        return $albums;
    }

    /**
     * Get album by id.
     *
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

    /**
     * Get pagination data.
     *
     * @param Album $album
     * @param $page
     * @return array
     */
    public function getAlbumPagination(Album $album, $page)
    {
        $imageRepository = $this->entityManager->getRepository(Image::class);
        $imageCount = $imageRepository->getCount($album);
        $numberOfPages = floor($imageCount/$this->imagesPerPage) + ceil(fmod($imageCount/$this->imagesPerPage, 1));

        return ['pages' => range(1, $numberOfPages), 'currentPage' => $page, 'albumId' => $album->getId()];
    }
}