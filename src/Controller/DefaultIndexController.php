<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Buzz\Client\FileGetContents;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultIndexController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DefaultIndexController.php',
        ]);
    }

    /**
     * @Route("/tests")
     */
    public function tests(){


        $request = new Request('GET', 'https://google.com');
        $client = new FileGetContents(new Psr17Factory(), ['allow_redirects' => true]);
        $response = $client->sendRequest($request, ['timeout' => 4]);

        return
           new Response( $response->getBody());

    }


    /**
     * @Route("/blog", name="blog_list")
     */
    public function list()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DefaultIndexController.php',
        ]);

    }

}
