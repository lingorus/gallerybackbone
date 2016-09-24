<?php

namespace AppBundle\DataFixtures\Orm;

use AppBundle\Entity\Album;
use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Vladislav Iavorskii
 */
class LoadAlbums implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $imagesDir = __DIR__.'/fixtures/images/';
        $imageDir = realpath(__DIR__ . '/../../Resources/public/images/');

        $fs = new Filesystem();
        $finder = new Finder();
        $finder->in($imagesDir);
        $images = $finder->getIterator();
        foreach ($images as $image) {
            $fs->copy($image->getRealPath(), $imageDir . '/' . $image->getFilename());
        }

        $fixtures = Yaml::parse(file_get_contents(__DIR__ . '/fixtures/albums.yml'));
        $albums = $fixtures['albums'];
        $images = $fixtures['images'];
        foreach ($albums as $key => $album) {
            $newAlbum = new Album();
            $newAlbum->setTitle($key);

            $manager->persist($newAlbum);

            foreach (range(1, $album['image_number']) as $item) {
                $imageIndex = rand(0, count($images)-1);
                $image = new Image();
                $image
                    ->setImageUrl($images[$imageIndex])
                    ->setAlbum($newAlbum)
                ;

                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}