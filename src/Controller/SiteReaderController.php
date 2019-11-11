<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Service\FileService;
use App\Service\HttpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class SiteReaderController extends FOSRestController
{
    /**
     * @Rest\Get("/read", name="site_reader")
     */
    public function index(FileService $fs, HttpService $ht)
    {
		
        $gcs = "fobj5";
        $out = $fs->read($gcs);
		//echo serialize($out);
        if ($out){
            return $this->json($out);
        }
        $out = array();

        $temp = $ht->readDatabyXPath("https://int.soccerway.com/national/england/premier-league/2011-2012/regular-season/r14829/matches/",
            "//*[contains(@class, 'matches')]/tbody/tr");
        array_walk($temp, function ($v,$k) use (&$out) {
           $day=$v->childNodes[1]->nodeValue.$v->childNodes[3]->nodeValue;
           $team1 = $v->childNodes[5]->nodeValue;
           $team2 = $v->childNodes[9]->nodeValue;
           $count = $v->childNodes[7]->nodeValue;
           $out[] = [
                "day"=>preg_replace('/[^A-Za-z0-9\-]/', '', $day),
                "team1"=>preg_replace('/[^A-Za-z0-9\-]/', '', $team1),
                "count"=>preg_replace('/[^A-Za-z0-9\-]/', '', $count),
                "team2"=>preg_replace('/[^A-Za-z0-9\-]/', '', $team2)
           ];

        });
        if (count($out)>1){
            $fs->write($gcs,$out);
            return $this->json($out);
        }
		
		
		

		$app->after(function (Request $request, Response $response) {
			   $response->headers->set('Content-Type', 'application/json');
				$response->headers->set("Access-Control-Allow-Headers", "Content-Type");
				$response->headers->set("Access-Control-Allow-Origin", "*");
			
		});
		
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SiteReaderController.php',
        ]);
    }

    /**route for vue
     * @Rest\Get("/readp", name="site_readerp")
     */
    public function index_post(Request $request){
		//$html = render_template('templates/show.php', ['post' => $post]);
		//$this->render('vue/index.html');
		return new Response(file_get_contents('vue.html'));
	   return $this->json([
            'req' => $request->get('myval'),
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SiteReaderController.php',
        ]);
    }

}
