<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/album/{id}", name="album")
     */
    public function albumAction(Request $request)
    {
        exit('albums');
    }

    /**
     * @Route("/album/{id}/page/{page}", name="page")
     */
    public function pageAction(Request $request)
    {
        exit('albums');
    }

    

}
