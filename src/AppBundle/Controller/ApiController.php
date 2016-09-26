<?php

namespace AppBundle\Controller;

use AppBundle\Services\AlbumProviderService;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Prefix;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @Get("/api/album/{id}", name="album")
     * @Get("/api/album/{id}/page/{page}", name="album_page")
     * @param Request $request
     * @param $id
     * @param int $page
     * @return Response
     * @throws \AppBundle\Services\Exception\AlbumNotFoundException
     */
    public function albumImagesAction(Request $request, $id, $page = 1)
    {
        $serializer = $this->get('serializer');
        $albumProvider = $this->get("appbundle.album.provider.service");
        $images = $albumProvider->getAlbumImages($id, $page);
        $album = $albumProvider->getAlbum($id);
        $album->setUrl($this->generateUrl('album_view', ['id' => $id]));
        $pagination = $albumProvider->getAlbumPagination($album, $page);

        $result = [
            'images'        => $images,
            'description'   => $album,
            'pagination'    => $pagination
        ];
        
        $response = new Response($serializer->serialize($result, 'json'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Get("api/albums", name="albums")
     */
    public function albumsAction()
    {
        $albumProvider = $this->get("appbundle.album.provider.service");
        $result = $albumProvider->getAlbums();

        return $result;
    }
}
