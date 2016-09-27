<?php

namespace AppBundle\Tests\Unit;
use AppBundle\Entity\Album;
use AppBundle\Entity\Image;
use AppBundle\Repositories\AlbumRepository;
use AppBundle\Repositories\ImageRepository;
use AppBundle\Services\AlbumProviderService;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Vladislav Iavorskii
 */
class AlbumProviderServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAlbum()
    {
        $album = $this->createMock(Album::class);

        $albumRepository = $this
            ->getMockBuilder(AlbumRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $albumRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($album));

        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($albumRepository));

        $albumProvider = new AlbumProviderService(10, $entityManager);
        $album = $albumProvider->getAlbum(4);

        $this->assertInstanceOf(Album::class, $album);
    }

    public function testGetAlbumImages()
    {
        $album = $this->createMock(Album::class);
        $image = $this->createMock(Image::class);

        $albumRepository = $this
            ->getMockBuilder(AlbumRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $albumRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($album));

        $imageRepository = $this
            ->getMockBuilder(ImageRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $imagesPerPage = 10;
        $imagesArray = [];
        foreach (range(1, $imagesPerPage) as $item) {
            $imagesArray[] = $image;
        }
        $imageRepository->expects($this->once())
            ->method("getImages")
            ->will($this->returnValue($imagesArray));

        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->exactly(2))
            ->method('getRepository')
            ->withConsecutive(
                [Album::class],
                [Image::class]
            )
            ->willReturnOnConsecutiveCalls($albumRepository, $imageRepository);

        $albumProvider = new AlbumProviderService($imagesPerPage, $entityManager);
        $albumImages = $albumProvider->getAlbumImages(4, 1);

        $this->assertTrue(is_array($albumImages));
        $this->assertTrue(count($albumImages) == $imagesPerPage);
    }


    public function testGetAlbumPagination()
    {
        $album = $this->createMock(Album::class);
        $album->expects($this->once())
            ->method("getId")
            ->willReturn(3);

        $imageRepository = $this
            ->getMockBuilder(ImageRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $imageRepository->expects($this->once())
            ->method("getCount")
            ->will($this->returnValue(37));

        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($imageRepository));

        $imagesPerPage = 10;
        $albumProvider = new AlbumProviderService($imagesPerPage, $entityManager);
        $pagination = $albumProvider->getAlbumPagination($album, 2);

        $this->assertTrue(is_array($pagination));
        $this->assertTrue(
            isset($pagination['pages'])
            && isset($pagination['currentPage'])
            && isset($pagination['albumId'])
        );

        $this->assertTrue(count($pagination['pages']) == 4);
        $this->assertTrue($pagination['currentPage'] == 2);
        $this->assertTrue($pagination['albumId'] == 3);
    }
}