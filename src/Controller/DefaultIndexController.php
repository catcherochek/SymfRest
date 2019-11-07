<?php

namespace App\Controller;

use App\Service\FileService;
use App\Service\HttpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

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
     *
     */
    public function tests(FileService $service){
        //$service->write("ffs","sdfsdfsdaf");
        return new Response($service->read("ffs"));
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
