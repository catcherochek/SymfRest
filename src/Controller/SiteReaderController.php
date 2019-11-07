<?php

namespace App\Controller;

use App\Service\FileService;
use App\Service\HttpService;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SiteReaderController.php',
        ]);
    }

    /**
     * @Rest\Post("/readp", name="site_readerp")
     */
    public function index_post(Request $request){
        return $this->json([
            'req' => $request->get('myval'),
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SiteReaderController.php',
        ]);
    }

}
